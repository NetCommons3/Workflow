<?php
/**
 * WorkflowControllerEditTest::testEditValidationError()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowControllerEditTest::testEditValidationError()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowControllerEditTest
 */
class TestSuiteWorkflowControllerEditTestTestEditValidationErrorTest extends NetCommonsControllerTestCase {

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
 * testEditValidationError()のテスト
 *
 * @return void
 */
	public function testTestEditValidationError() {
		//データ生成
		$data = array();
		$urlOptions = array('action' => 'edit_validation_error');
		$validationError = array(
			'field' => 'validationField',
			'value' => 'validationValue',
			'message' => 'validationMessage',
		);

		//テスト実施
		$result = $this->TestSuite->testEditValidationError($data, $urlOptions, $validationError);

		//チェック
		$this->assertEquals('edit_validation_error', $result->controller->view);

		$pattern = '/' . preg_quote('TestSuite/WorkflowControllerEditTest/edit_validation_error.ctp', '/') . '/';
		$this->assertRegExp($pattern, $result->view);
	}

}
