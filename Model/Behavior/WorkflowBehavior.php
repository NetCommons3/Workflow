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

/**
 * Workflow Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package  NetCommons\Workflow\Model\Befavior
 */
class WorkflowBehavior extends ModelBehavior {

/**
 * status list for editor
 *
 * @var array
 */
	static public $statusesForEditor = array(
		WorkflowComponent::STATUS_APPROVED,
		WorkflowComponent::STATUS_IN_DRAFT
	);

/**
 * status list
 *
 * @var array
 */
	static public $statuses = array(
		WorkflowComponent::STATUS_PUBLISHED,
		//WorkflowComponent::STATUS_APPROVED,
		WorkflowComponent::STATUS_IN_DRAFT,
		WorkflowComponent::STATUS_DISAPPROVED
	);

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
		if (isset($model->data[$model->name]['id']) && $model->data[$model->name]['id'] > 0) {
			// updateのときは何もしない
			return true;
		}

		$needFields = array('status', 'is_active', 'is_latest');
		if ($this->__hasSaveField($model, $needFields, false)) {
			if ($this->__hasSaveField($model, ['origin_id', 'language_id'], true)) {
				$originalField = 'origin_id';
			} elseif ($this->__hasSaveField($model, ['key', 'language_id'], true)) {
				$originalField = 'key';
			} else {
				return true;
			}

			//is_activeのセット
			$model->data[$model->name]['is_active'] = false;
			if ($model->data[$model->name]['status'] === WorkflowComponent::STATUS_PUBLISHED) {
				//statusが公開ならis_activeを付け替える
				$model->data[$model->name]['is_active'] = true;

				//現状のis_activeを外す
				if ($model->data[$model->name][$originalField]) {
					$model->updateAll(
						array($model->name . '.is_active' => false),
						array(
							$model->name . '.' . $originalField => $model->data[$model->name][$originalField],
							$model->name . '.language_id' => (int)$model->data[$model->name]['language_id'],
							$model->name . '.is_active' => true,
						)
					);
				}
			}

			//is_latestのセット
			$model->data[$model->name]['is_latest'] = true;

			//現状のis_latestを外す
			if ($model->data[$model->name][$originalField]) {
				$model->updateAll(
					array($model->name . '.is_latest' => false),
					array(
						$model->name . '.' . $originalField => $model->data[$model->name][$originalField],
						$model->name . '.language_id' => (int)$model->data[$model->name]['language_id'],
						$model->name . '.is_latest' => true,
					)
				);
			}
		}

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
 * @param bool $validateData True on validate data.
 * @return bool True if $model has the required fields
 */
	private function __hasSaveField(Model $model, $needle, $validateData) {
		$fields = is_string($needle) ? array($needle) : $needle;

		foreach ($fields as $key) {
			if (! $model->hasField($key)) {
				return false;
			}
			if ($validateData && ! array_key_exists($key, $model->data[$model->name])) {
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
			$latestConditons = array(
				$model->alias . '.is_latest' => true,
				$model->alias . '.created_user' => Current::read('User.id'),
			);
		} else {
			$activeConditions = array(
				$model->alias . '.is_active' => true,
			);
			$latestConditons = array();
		}

		if ($model->hasField('language_id')) {
			$langConditions = array(
				$model->alias . '.language_id' => Current::read('Language.id'),
			);
		} else {
			$langConditions = array();
		}
		$conditions = Hash::merge($langConditions, array(
			'OR' => array($activeConditions, $latestConditons)
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
 * Check creatable permission
 *
 * @param Model $model Model using this behavior
 * @return array Conditions data
 */
	public function canReadWorkflowContent(Model $model) {
		return Current::permission('content_readable');
	}

/**
 * Check creatable permission
 *
 * @param Model $model Model using this behavior
 * @return array Conditions data
 */
	public function canCreateWorkflowContent(Model $model) {
		return Current::permission('content_creatable');
	}

/**
 * Check editable permission
 *
 * @param Model $model Model using this behavior
 * @param string $type Type of find operation (all / first / count / neighbors / list / threaded)
 * @return array Conditions data
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
		return ($data[$model->alias]['created_user'] === Current::read('User.id'));
	}

/**
 * Check deletable permission
 *
 * @param Model $model Model using this behavior
 * @param string $type Type of find operation (all / first / count / neighbors / list / threaded)
 * @return array Conditions data
 */
	public function canDeleteWorkflowContent(Model $model, $data) {
		if (Current::permission('content_publishable')) {
			return true;
		}
		if (! $this->canEditWorkflowContent($model, $data)) {
			return false;
		}
		if (! isset($data[$model->alias])) {
			$data[$model->alias] = $data;
		}

		$conditions = array(
			'is_active' => true,
		);
		if ($model->hasField('origin_id') && isset($data[$model->alias]['origin_id'])) {
			$conditions['origin_id'] = $data[$model->alias]['origin_id'];
		} elseif ($model->hasField('key') && isset($data[$model->alias]['key'])) {
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

}
