<?php
/**
 * WorkflowControllerAddTest::testAddGetByCreatable()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowControllerAddTest::testAddGetByCreatable()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowControllerAddTest
 */
class TestSuiteWorkflowControllerAddTestTestAddGetByCreatableTest extends NetCommonsControllerTestCase {

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
 * testAddGetByCreatable()のテスト
 *
 * @return void
 */
	public function testTestAddGetByCreatable() {
		//データ生成
		$urlOptions = null;
		$assert = null;
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testAddGetByCreatable($urlOptions, $assert, $exception, $return);

		//チェック
		$pattern = '/' . preg_quote('TestSuite/WorkflowControllerAddTest', '/') . '/';
		$this->assertRegExp($pattern, $result->view);
	}

}
