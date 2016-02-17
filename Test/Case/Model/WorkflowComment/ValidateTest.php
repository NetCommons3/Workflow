<?php
/**
 * WorkflowComment::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('WorkflowCommentFixture', 'Workflow.Test/Fixture');

/**
 * WorkflowComment::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\WorkflowComment
 */
class WorkflowCommentValidateTest extends NetCommonsValidateTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.workflow_comment',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'workflow';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'WorkflowComment';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'validates';

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ(省略可)
 *
 * @return array テストデータ
 */
	public function dataProviderValidationError() {
		$data['WorkflowComment'] = (new WorkflowCommentFixture())->records[0];

		return array(
			array('data' => $data, 'field' => 'plugin_key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'block_key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'content_key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),

			//差し戻しの時
			array('data' => $data, 'field' => 'comment', 'value' => '',
				'message' => __d('net_commons', 'If it is not approved, comment is a required input.')),
		);
	}

}
