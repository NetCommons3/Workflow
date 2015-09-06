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

		$needFields = ['status', 'is_active', 'is_latest'];
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

}
