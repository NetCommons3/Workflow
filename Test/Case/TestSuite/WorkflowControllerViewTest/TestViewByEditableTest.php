<?php
/**
 * WorkflowControllerViewTest::testViewByEditable()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowControllerViewTest::testViewByEditable()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowControllerViewTest
 */
class TestSuiteWorkflowControllerViewTestTestViewByEditableTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteWorkflowControllerViewTest', 'TestWorkflow.TestSuite');
		$this->TestSuite = new TestSuiteWorkflowControllerViewTest();
	}

/**
 * testViewByEditable()のテスト
 *
 * @return void
 */
	public function testTestViewByEditable() {
		//データ生成
		$urlOptions = array();
		$assert = array('method' => 'assertNotEmpty');
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testViewByEditable($urlOptions, $assert, $exception, $return);

		//チェック
		$this->assertEquals('editor', $result->controller->viewVars['username']);

		$pattern = '/' . preg_quote('TestSuite/WorkflowControllerViewTest/view.ctp', '/') . '/';
		$this->assertRegExp($pattern, $result->view);
	}

}
