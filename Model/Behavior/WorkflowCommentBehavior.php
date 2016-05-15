<?php
/**
 * WorkflowComment Behavior
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
 * WorkflowComment Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Model\Behavior
 */
class WorkflowCommentBehavior extends ModelBehavior {

/**
 * 削除するデータ保持用配列
 *
 * @var array
 */
	protected $_deletedRow = array();

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
		if (! isset($model->data['WorkflowComment'])) {
			return true;
		}

		$model->loadModels(array(
			'WorkflowComment' => 'Workflow.WorkflowComment',
		));

		//コメントの登録(ステータス 差し戻しのみコメント必須)
		$model->data[$model->alias]['status'] = Hash::get($model->data, $model->alias . '.status');
		if ($model->data[$model->alias]['status'] === WorkflowComponent::STATUS_DISAPPROVED ||
				Hash::get($model->data, 'WorkflowComment.comment', '') !== '') {

			$model->WorkflowComment->set($model->data['WorkflowComment']);
			$model->WorkflowComment->validates();

			if ($model->WorkflowComment->validationErrors) {
				$model->validationErrors = Hash::merge(
					$model->validationErrors,
					$model->WorkflowComment->validationErrors
				);
				return false;
			}
		}

		return true;
	}

/**
 * afterSave is called after a model is saved.
 *
 * @param Model $model Model using this behavior
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return bool
 * @throws InternalErrorException
 * @see Model::save()
 */
	public function afterSave(Model $model, $created, $options = array()) {
		$model->loadModels([
			'WorkflowComment' => 'Workflow.WorkflowComment',
		]);

		if (! Hash::get($model->data, 'WorkflowComment.comment')) {
			return true;
		}

		$model->data['WorkflowComment']['plugin_key'] = Inflector::underscore($model->plugin);
		$model->data['WorkflowComment']['block_key'] = $model->data['Block']['key'];
		$model->data['WorkflowComment']['content_key'] = $model->data[$model->alias]['key'];

		if (! $model->WorkflowComment->save($model->data['WorkflowComment'], false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return parent::afterSave($model, $created, $options);
	}

/**
 * Before delete is called before any delete occurs on the attached model, but after the model's
 * beforeDelete is called. Returning false from a beforeDelete will abort the delete.
 *
 * @param Model $model Model using this behavior
 * @param bool $cascade If true records that depend on this record will also be deleted
 * @return mixed False if the operation should abort. Any other result will continue.
 * @throws InternalErrorException
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function beforeDelete(Model $model, $cascade = true) {
		$model->loadModels([
			'WorkflowComment' => 'Workflow.WorkflowComment',
		]);

		//idからkey取得
		if (! $model->blockKey && ! $model->contentKey && $model->hasField('key')) {
			$content = $model->find('first', array(
				'recursive' => -1,
				'conditions' => array('id' => $model->id)
			));
			$model->contentKey = Hash::get($content, $model->alias . '.key');
		}

		return true;
	}

/**
 * After delete is called after any delete occurs on the attached model.
 *
 * @param Model $model Model using this behavior
 * @return void
 * @throws InternalErrorException
 */
	public function afterDelete(Model $model) {
		$model->loadModels([
			'WorkflowComment' => 'Workflow.WorkflowComment',
		]);

		if ($model->blockKey) {
			$conditions = array($model->WorkflowComment->alias . '.block_key' => $model->blockKey);
			if (! $model->WorkflowComment->deleteAll($conditions, false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		} elseif ($model->contentKey) {
			$conditions = array($model->WorkflowComment->alias . '.content_key' => $model->contentKey);
			if (! $model->WorkflowComment->deleteAll($conditions, false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}
	}

/**
 * Get WorkflowComment data
 *
 * @param Model $model Model using this behavior
 * @param string $contentKey Content key
 * @return array
 */
	public function getCommentsByContentKey(Model $model, $contentKey) {
		$model->loadModels(array(
			'WorkflowComment' => 'Workflow.WorkflowComment',
		));

		if (! $contentKey) {
			return array();
		}

		$conditions = array(
			'content_key' => $contentKey,
			'plugin_key' => Inflector::underscore($model->plugin),
		);
		$comments = $model->WorkflowComment->find('all', array(
			'conditions' => $conditions,
			'order' => 'WorkflowComment.id DESC',
		));

		return $comments;
	}

/**
 * Delete comments by content key
 *
 * @param Model $model Model using this behavior
 * @param string $contentKey content key
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function deleteCommentsByContentKey(Model $model, $contentKey) {
		$model->loadModels(array(
			'WorkflowComment' => 'Workflow.WorkflowComment',
		));

		$conditions = array($model->WorkflowComment->alias . '.content_key' => $contentKey);
		if (! $model->WorkflowComment->deleteAll($conditions, false, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}
}
