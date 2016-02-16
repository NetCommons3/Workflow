<?php
/**
 * WorkflowControllerDeleteTest::testDeletePost()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowControllerDeleteTest::testDeletePost()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowControllerDeleteTest
 */
class TestSuiteWorkflowControllerDeleteTestTestDeletePostTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteWorkflowControllerDeleteTest', 'TestWorkflow.TestSuite');
		$this->TestSuite = new TestSuiteWorkflowControllerDeleteTest();
	}

/**
 * testDeletePost()のテスト
 *
 * @return void
 */
	public function testTestDeletePost() {
		//データ生成
		$data = array();
		$role = Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR;
		$urlOptions = array('action' => 'delete_post');
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testDeletePost($data, $role, $urlOptions, $exception, $return);

		//チェック
		$this->assertEquals('delete_post', $result->controller->view);

		$header = $result->controller->response->header();
		$assertUrl = Inflector::underscore('TestWorkflow') . '/' . Inflector::underscore('TestSuiteWorkflowControllerDeleteTest') . '/index';
		$this->assertContains($assertUrl, $header['Location']);
	}
}
