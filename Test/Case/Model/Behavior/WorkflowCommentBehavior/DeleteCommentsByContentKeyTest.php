<?php
/**
 * WorkflowCommentBehavior::deleteCommentsByContentKey()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowCommentBehavior::deleteCommentsByContentKey()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\Behavior\WorkflowCommentBehavior
 */
class WorkflowCommentBehaviorDeleteCommentsByContentKeyTest extends NetCommonsModelTestCase {

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
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Workflow', 'TestWorkflow');
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowCommentBehaviorModel');
		$this->WorkflowComment = ClassRegistry::init('Workflow.WorkflowComment');
	}

/**
 * deleteCommentsByContentKey()テストのDataProvider
 *
 * ### 戻り値
 *  - contentKey content key
 *
 * @return array データ
 */
	public function dataProvider() {
		$result = array();
		$result[0]['contentKey'] = 'comment_content_1';

		return $result;
	}

/**
 * deleteCommentsByContentKey()のテスト
 *
 * @param string $contentKey content key
 * @dataProvider dataProvider
 * @return void
 */
	public function testDeleteCommentsByContentKey($contentKey) {
		$count = $this->WorkflowComment->find('count', array('recursive' => -1));
		$this->assertEqual(2, $count);

		//テスト実施
		$result = $this->TestModel->deleteCommentsByContentKey($contentKey);
		$this->assertTrue($result);

		//チェック
		$count = $this->WorkflowComment->find('count', array('recursive' => -1));
		$this->assertEqual(0, $count);
	}

/**
 * deleteCommentsByContentKey()のExceptionErrorテスト
 *
 * @param string $contentKey content key
 * @dataProvider dataProvider
 * @return void
 */
	public function testDeleteCommentsByContentKeyOnExceptionError($contentKey) {
		$this->_mockForReturnFalse('TestModel', 'Workflow.WorkflowComment', 'deleteAll');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->deleteCommentsByContentKey($contentKey);
	}

}
