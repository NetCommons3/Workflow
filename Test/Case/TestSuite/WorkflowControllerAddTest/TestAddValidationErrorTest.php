<?php
/**
 * WorkflowControllerAddTest::testAddValidationError()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowControllerAddTest::testAddValidationError()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowControllerAddTest
 */
class TestSuiteWorkflowControllerAddTestTestAddValidationErrorTest extends NetCommonsControllerTestCase {

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
 * testAddValidationError()のテスト
 *
 * @return void
 */
	public function testTestAddValidationError() {
		//データ生成
		$data = array();
		$urlOptions = array('action' => 'add_validation_error');
		$validationError = array(
			'field' => 'validationField',
			'value' => 'validationValue',
			'message' => 'validationMessage',
		);

		//テスト実施
		$result = $this->TestSuite->testAddValidationError($data, $urlOptions, $validationError);

		//チェック
		$this->assertEquals('add_validation_error', $result->controller->view);

		$pattern = '/' . preg_quote('TestSuite/WorkflowControllerAddTest/add_validation_error.ctp', '/') . '/';
		$this->assertRegExp($pattern, $result->view);
	}

}
