<?php
/**
 * WorkflowControllerEditTest::testEditGetByPublishable()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowControllerEditTest::testEditGetByPublishable()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowControllerEditTest
 */
class TestSuiteWorkflowControllerEditTestTestEditGetByPublishableTest extends NetCommonsControllerTestCase {

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
 * testEditGetByPublishable()のテスト
 *
 * @return void
 */
	public function testTestEditGetByPublishable() {
		//データ生成
		$urlOptions = array();
		$assert = array('method' => 'assertNotEmpty');
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testEditGetByPublishable($urlOptions, $assert, $exception, $return);

		//チェック
		$this->assertEquals('chief_editor', $result->controller->viewVars['username']);

		$pattern = '/' . preg_quote('TestSuite/WorkflowControllerEditTest/edit.ctp', '/') . '/';
		$this->assertRegExp($pattern, $result->view);
	}

}
