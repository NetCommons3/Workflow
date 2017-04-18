<?php
/**
 * Workflow Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');
App::uses('NetCommonsTime', 'NetCommons.Utility');

/**
 * Workflow Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package  NetCommons\Workflow\Model\Befavior
 */
class WorkflowBehavior extends ModelBehavior {

/**
 * Block type
 *
 * @var int
 */
	const
		PUBLIC_TYPE_PRIVATE = '0',
		PUBLIC_TYPE_PUBLIC = '1',
		PUBLIC_TYPE_LIMITED = '2';

/**
 * status list for editor
 *
 * @var array
 */
	static public $statusesForEditor = array(
		WorkflowComponent::STATUS_APPROVAL_WAITING,
		WorkflowComponent::STATUS_IN_DRAFT
	);

/**
 * status list
 *
 * @var array
 */
	static public $statuses = array(
		WorkflowComponent::STATUS_PUBLISHED,
		//WorkflowComponent::STATUS_APPROVAL_WAITING,
		WorkflowComponent::STATUS_IN_DRAFT,
		WorkflowComponent::STATUS_DISAPPROVED
	);

/**
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model Model using this behavior
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		parent::setup($model, $config);

		//ビヘイビアの優先順位
		$this->settings['priority'] = 9;
	}

/**
 * beforeSave is called before a model is saved. Returning false from a beforeSave callback
 * will abort the save operation.
 *
 * @param Model $model Model using this behavior
 * @param array $options Options passed from Model::save().
 * @return mixed False if the operation should abort. Any other result will continue.
 * @see Model::save()
 */
	public function beforeSave(Model $model, $options = array()) {
		//  beforeSave はupdateAllでも呼び出される。
		if (isset($model->data[$model->alias]['id']) && $model->data[$model->alias]['id'] > 0) {
			// updateのときは何もしない
			return true;
		}

		if (! $this->__hasSaveField($model, array('status', 'is_active', 'is_latest'))) {
			return true;
		}
		if ($this->__hasSaveField($model, array('key'))) {
			$originalField = 'key';
			if (! Hash::get($model->data[$model->alias], $originalField)) {
				//OriginalKeyBehaviorでセットされるはずなので、falseで返却
				return false;
			}

			if ($this->__hasSaveField($model, array('language_id'))) {
				$commonConditions = array(
					$model->alias . '.' . $originalField => $model->data[$model->alias][$originalField],
					$model->alias . '.language_id' => Hash::get(
						$model->data[$model->alias], 'language_id', Current::read('Language.id')
					),
				);
			} else {
				$commonConditions = array(
					$model->alias . '.' . $originalField => $model->data[$model->alias][$originalField],
				);
			}

		} else {
			return true;
		}

		//作成者のコピー
		$created = $model->find('first', array(
			'recursive' => -1,
			'fields' => array('created', 'created_user'),
			'conditions' => array(
				$originalField => $model->data[$model->alias][$originalField]
			),
			'callbacks' => false,
		));
		if ($created) {
			$model->data[$model->alias]['created'] = $created[$model->alias]['created'];
			$model->data[$model->alias]['created_user'] = $created[$model->alias]['created_user'];
		}

		//is_activeのセット
		$model->data[$model->alias]['is_active'] = false;
		if ($model->data[$model->alias]['status'] === WorkflowComponent::STATUS_PUBLISHED) {
			//statusが公開ならis_activeを付け替える
			$model->data[$model->alias]['is_active'] = true;

			//現状のis_activeを外す
			$model->updateAll(
				array($model->alias . '.is_active' => false),
				Hash::merge($commonConditions, array(
					$model->alias . '.is_active' => true,
				))
			);
		}

		//is_latestのセット
		$model->data[$model->alias]['is_latest'] = true;

		//現状のis_latestを外す
		$model->updateAll(
			array($model->alias . '.is_latest' => false),
			Hash::merge($commonConditions, array(
				$model->alias . '.is_latest' => true,
			))
		);

		return true;
	}

/**
 * beforeValidate is called before a model is validated, you can use this callback to
 * add behavior validation rules into a models validate array. Returning false
 * will allow you to make the validation fail.
 *
 * @param Model $model Model using this behavior
 * @param array $options Options passed from Model::save().
 * @return mixed False or null will abort the operation. Any other result will continue.
 * @see Model::save()
 */
	public function beforeValidate(Model $model, $options = array()) {
		if (! $model->hasField('status')) {
			return parent::beforeValidate($model, $options);
		}

		if (Current::permission('content_publishable')) {
			$statuses = self::$statuses;
		} else {
			$statuses = self::$statusesForEditor;
		}

		$model->validate = Hash::merge($model->validate, array(
			'status' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
				'inList' => array(
					'rule' => array('inList', $statuses),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
		));

		return parent::beforeValidate($model, $options);
	}

/**
 * Checks wether model has the required fields
 *
 * @param Model $model instance of model
 * @param mixed $needle The searched value.
 * @return bool True if $model has the required fields
 */
	private function __hasSaveField(Model $model, $needle) {
		$fields = is_string($needle) ? array($needle) : $needle;

		foreach ($fields as $key) {
			if (! $model->hasField($key)) {
				return false;
			}
		}

		if (in_array('language_id', $fields)) {
			if (! $model->Behaviors->loaded('M17n.M17n')) {
				$model->Behaviors->load('M17n.M17n');
			}
			if (! $model->isM17nGeneralPlugin()) {
				return false;
			}
		}

		return true;
	}

/**
 * Get workflow conditions
 *
 * @param Model $model Model using this behavior
 * @param array $conditions Model::find conditions default value
 * @return array Conditions data
 */
	public function getWorkflowConditions(Model $model, $conditions = array()) {
		if (Current::permission('content_editable')) {
			$activeConditions = array();
			$latestConditons = array(
				$model->alias . '.is_latest' => true,
			);
		} elseif (Current::permission('content_creatable')) {
			$activeConditions = array(
				$model->alias . '.is_active' => true,
				$model->alias . '.created_user !=' => Current::read('User.id'),
			);
			// 時限公開条件追加
			if ($model->hasField('public_type')) {
				$publicTypeConditions = $this->_getPublicTypeConditions($model);
				$activeConditions[] = $publicTypeConditions;
			}
			$latestConditons = array(
				$model->alias . '.is_latest' => true,
				$model->alias . '.created_user' => Current::read('User.id'),
			);
		} else {
			// 時限公開条件追加
			$activeConditions = array(
				$model->alias . '.is_active' => true,
			);
			if ($model->hasField('public_type')) {
				$publicTypeConditions = $this->_getPublicTypeConditions($model);
				$activeConditions[] = $publicTypeConditions;
			}
			$latestConditons = array();
		}

		if ($model->hasField('language_id')) {
			if (Current::read('Plugin.is_m17n') === false && $model->hasField('is_origin')) {
				$langConditions = array(
					$model->alias . '.is_origin' => true,
				);
			} elseif ($model->hasField('is_translation')) {
				$langConditions = array(
					'OR' => array(
						$model->alias . '.language_id' => Current::read('Language.id'),
						$model->alias . '.is_translation' => false,
					)
				);
			} else {
				$langConditions = array(
					$model->alias . '.language_id' => Current::read('Language.id'),
				);
			}
		} else {
			$langConditions = array();
		}

		$conditions = Hash::merge(
			array(
				$langConditions,
				array('OR' => array($activeConditions, $latestConditons))
			),
			$conditions
		);

		return $conditions;
	}

/**
 * Get workflow conditions omit publish period
 *
 * @param Model $model Model using this behavior
 * @param array $conditions Model::find conditions default value
 * @return array Conditions data
 */
	public function getWorkflowConditionsOmitPublishPeriod(Model $model, $conditions = array()) {
		if (Current::permission('content_editable')) {
			$activeConditions = array();
			$latestConditions = array(
				$model->alias . '.is_latest' => true,
			);
		} elseif (Current::permission('content_creatable')) {
			$activeConditions = array(
				$model->alias . '.is_active' => true,
				$model->alias . '.created_user !=' => Current::read('User.id'),
			);
			$latestConditions = array(
				$model->alias . '.is_latest' => true,
				$model->alias . '.created_user' => Current::read('User.id'),
			);
		} else {
			// 時限公開条件追加
			$activeConditions = array(
				$model->alias . '.is_active' => true,
			);
			$latestConditions = array();
		}

		if ($model->hasField('language_id')) {
			$langConditions = array(
				$model->alias . '.language_id' => Current::read('Language.id'),
			);
		} else {
			$langConditions = array();
		}
		$conditions = Hash::merge($langConditions, array(
			'OR' => array($activeConditions, $latestConditions)
		), $conditions);

		return $conditions;
	}

/**
 * Get workflow contents
 *
 * @param Model $model Model using this behavior
 * @param string $type Type of find operation (all / first / count / neighbors / list / threaded)
 * @param array $query Option fields (conditions / fields / joins / limit / offset / order / page / group / callbacks)
 * @return array Conditions data
 */
	public function getWorkflowContents(Model $model, $type, $query = array()) {
		$query = Hash::merge(array(
			'recursive' => -1,
			'conditions' => $this->getWorkflowConditions($model)
		), $query);

		return $model->find($type, $query);
	}

/**
 * コンテンツの閲覧権限があるかどうかのチェック
 * - 閲覧権限あり(content_readable)
 *
 * @param Model $model Model using this behavior
 * @return bool true:閲覧可、false:閲覧不可
 */
	public function canReadWorkflowContent(Model $model) {
		return Current::permission('content_readable');
	}

/**
 * コンテンツの作成権限があるかどうかのチェック
 * - 作成権限あり(content_creatable)
 *
 * @param Model $model Model using this behavior
 * @return bool true:作成可、false:作成不可
 */
	public function canCreateWorkflowContent(Model $model) {
		return Current::permission('content_creatable');
	}

/**
 * コンテンツの編集権限があるかどうかのチェック
 * - 編集権限あり(content_editable)
 * - 自分自身のコンテンツ
 *
 * @param Model $model Model using this behavior
 * @param array $data コンテンツデータ
 * @return bool true:編集可、false:編集不可
 */
	public function canEditWorkflowContent(Model $model, $data) {
		if (Current::permission('content_editable')) {
			return true;
		}
		if (! isset($data[$model->alias])) {
			$data[$model->alias] = $data;
		}
		if (! isset($data[$model->alias]['created_user'])) {
			return false;
		}
		return ((int)$data[$model->alias]['created_user'] === (int)Current::read('User.id'));
	}

/**
 * コンテンツの公開権限があるかどうかのチェック
 * - 公開権限あり(content_publishable) and 編集権限あり(content_editable)
 * - 自分自身のコンテンツ＋一度も公開されていない
 *
 * @param Model $model Model using this behavior
 * @param array $data コンテンツデータ
 * @return bool true:削除可、false:削除不可
 */
	public function canDeleteWorkflowContent(Model $model, $data) {
		if (! $this->canEditWorkflowContent($model, $data)) {
			return false;
		}
		if (Current::permission('content_publishable')) {
			return true;
		}
		if (! isset($data[$model->alias])) {
			$data[$model->alias] = $data;
		}

		$conditions = array(
			'is_active' => true,
		);
		if ($model->hasField('key') && isset($data[$model->alias]['key'])) {
			$conditions['key'] = $data[$model->alias]['key'];
		} else {
			return false;
		}

		$count = $model->find('count', array(
			'recursive' => -1,
			'conditions' => $conditions
		));
		return ((int)$count === 0);
	}

/**
 * 時限公開のconditionsを返す
 *
 * @param Model $model 対象モデル
 * @return array
 */
	protected function _getPublicTypeConditions(Model $model) {
		$netCommonsTime = new NetCommonsTime();
		$limitedConditions = array();
		$limitedConditions[$model->alias . '.public_type'] = self::PUBLIC_TYPE_LIMITED;
		if ($model->hasField('publish_start')) {
			$limitedConditions[] = array(
				'OR' => array(
					$model->alias . '.publish_start <=' => $netCommonsTime->getNowDatetime(),
					$model->alias . '.publish_start' => null,
				)
			);
		}
		if ($model->hasField('publish_end')) {
			$limitedConditions[] = array(
				'OR' => array(
					$model->alias . '.publish_end >=' => $netCommonsTime->getNowDatetime(),
					$model->alias . '.publish_end' => null,
				)
			);
		}

		$publicTypeConditions = array(
			'OR' => array(
				$model->alias . '.public_type' => self::PUBLIC_TYPE_PUBLIC,
				$limitedConditions,
			)
		);
		return $publicTypeConditions;
	}

}
