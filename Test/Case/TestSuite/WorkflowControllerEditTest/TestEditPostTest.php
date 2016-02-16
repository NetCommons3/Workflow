<?php
/**
 * WorkflowControllerEditTest::testEditPost()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowControllerEditTest::testEditPost()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowControllerEditTest
 */
class TestSuiteWorkflowControllerEditTestTestEditPostTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

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
		App::uses('TestSuiteWorkflowControllerEditTest', 'TestWorkflow.TestSuite');
		$this->TestSuite = new TestSuiteWorkflowControllerEditTest();
	}

/**
 * testEditPost()のテスト
 *
 * @return void
 */
	public function testTestEditPost() {
		//データ生成
		$data = array();
		$role = Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR;
		$urlOptions = array('action' => 'edit_post');
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testEditPost($data, $role, $urlOptions, $exception, $return);

		//チェック
		$this->assertEquals('edit_post', $result->controller->view);
		$this->assertEquals('PUT', $result->controller->request->method());

		$header = $result->controller->response->header();
		$assertUrl = Inflector::underscore('TestWorkflow') . '/' . Inflector::underscore('TestSuiteWorkflowControllerEditTest') . '/index';
		$this->assertContains($assertUrl, $header['Location']);
	}

}
