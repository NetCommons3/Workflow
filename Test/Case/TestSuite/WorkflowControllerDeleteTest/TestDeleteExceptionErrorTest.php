<?php
/**
 * WorkflowControllerDeleteTest::testDeleteExceptionError()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowControllerDeleteTest::testDeleteExceptionError()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowControllerDeleteTest
 */
class TestSuiteWorkflowControllerDeleteTestTestDeleteExceptionErrorTest extends NetCommonsControllerTestCase {

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
 * testDeleteExceptionError()のテスト
 *
 * @return void
 */
	public function testTestDeleteExceptionError() {
		//データ生成
		$mockModel = 'Workflow.WorkflowComment';
		$mockMethod = 'find';
		$data = array();
		$urlOptions = array('action' => 'delete_exception_error');
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testDeleteExceptionError($mockModel, $mockMethod, $data, $urlOptions, $exception, $return);

		//チェック
		$this->assertEquals('delete_exception_error', $result->controller->view);

		$header = $result->controller->response->header();
		$assertUrl = Inflector::underscore('TestWorkflow') . '/' . Inflector::underscore('TestSuiteWorkflowControllerDeleteTest') . '/index';
		$this->assertContains($assertUrl, $header['Location']);
	}

}
