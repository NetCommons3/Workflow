<?php
/**
 * Comment Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * Comment Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Model\Behavior
 */
class CommentBehavior extends ModelBehavior {

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
		if (! isset($model->data['Comment'])) {
			return true;
		}

		$model->loadModels(array(
			'Comment' => 'Workflow.Comment',
		));

		//コメントの登録(ステータス 差し戻しのみコメント必須)
		if (! isset($model->data[$model->alias]['status'])) {
			$model->data[$model->alias]['status'] = null;
		}
		if ($model->data[$model->alias]['status'] === WorkflowComponent::STATUS_DISAPPROVED ||
				isset($model->data['Comment']['comment']) && $model->data['Comment']['comment'] !== '') {

			$model->Comment->set($model->data['Comment']);
			$model->Comment->validates();

			if ($model->Comment->validationErrors) {
				$model->validationErrors = Hash::merge($model->validationErrors, $model->Comment->validationErrors);
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
		if (! isset($model->data['Comment']) || ! $model->data['Comment']['comment']) {
			return true;
		}

		$model->loadModels([
			'Comment' => 'Workflow.Comment',
		]);

		$model->data['Comment']['plugin_key'] = Inflector::underscore($model->plugin);
		$model->data['Comment']['block_key'] = $model->data['Block']['key'];
		$model->data['Comment']['content_key'] = $model->data[$model->alias]['key'];

		if (! $model->Comment->save($model->data['Comment'], false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return parent::afterSave($model, $created, $options);
	}

/**
 * Get Comments data
 *
 * @param Model $model Model using this behavior
 * @param string $contentKey Content key
 * @return array
 */
	public function getCommentsByContentKey(Model $model, $contentKey) {
		$model->Comment = ClassRegistry::init('Workflow.Comment');

		if (! $contentKey) {
			return array();
		}

		$conditions = array(
			'content_key' => $contentKey,
			'plugin_key' => Inflector::underscore($model->plugin),
		);
		$comments = $model->Comment->find('all', array(
			'conditions' => $conditions,
			'order' => 'Comment.id DESC',
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
			'Comment' => 'Workflow.Comment',
		));

		if (! $model->Comment->deleteAll(array($model->Comment->alias . '.content_key' => $contentKey), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}
}
