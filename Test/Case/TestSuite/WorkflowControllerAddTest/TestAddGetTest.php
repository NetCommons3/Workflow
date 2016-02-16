<?php
/**
 * WorkflowControllerAddTest::testAddGet()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowControllerAddTest::testAddGet()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowControllerAddTest
 */
class TestSuiteWorkflowControllerAddTestTestAddGetTest extends NetCommonsControllerTestCase {

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
 * testAddGet()のテスト
 *
 * @return void
 */
	public function testTestAddGet() {
		//データ生成
		$urlOptions = array();
		$assert = array('method' => 'assertNotEmpty');
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testAddGet($urlOptions, $assert, $exception, $return);

		//チェック
		$this->assertNull($result->controller->viewVars['username']);

		$pattern = '/' . preg_quote('TestSuite/WorkflowControllerAddTest/add.ctp', '/') . '/';
		$this->assertRegExp($pattern, $result->view);
	}

}
