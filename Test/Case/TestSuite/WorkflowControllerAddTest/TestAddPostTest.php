<?php
/**
 * WorkflowControllerAddTest::testAddPost()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowControllerAddTest::testAddPost()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowControllerAddTest
 */
class TestSuiteWorkflowControllerAddTestTestAddPostTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteWorkflowControllerAddTest', 'TestWorkflow.TestSuite');
		$this->TestSuite = new TestSuiteWorkflowControllerAddTest();
	}

/**
 * testAddPost()のテスト
 *
 * @return void
 */
	public function testTestAddPost() {
		//データ生成
		$data = array();
		$role = Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR;
		$urlOptions = array('action' => 'add_post');
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testAddPost($data, $role, $urlOptions, $exception, $return);

		//チェック
		$header = $result->controller->response->header();
		$assertUrl = Inflector::underscore('TestWorkflow') . '/' . Inflector::underscore('TestSuiteWorkflowControllerAddTest') . '/index';
		$this->assertContains($assertUrl, $header['Location']);
	}

}
