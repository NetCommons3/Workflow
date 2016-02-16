<?php
/**
 * WorkflowSaveTest::testCallWorkflowBehavior()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowSaveTest::testCallWorkflowBehavior()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowSaveTest
 */
class TestSuiteWorkflowSaveTestTestCallWorkflowBehaviorTest extends NetCommonsCakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.test_suite_workflow_save_test_model',
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
		App::uses('TestSuiteWorkflowSaveTest', 'TestWorkflow.TestSuite');
		$this->TestSuite = new TestSuiteWorkflowSaveTest();
	}

/**
 * testCallWorkflowBehavior()のテスト
 *
 * @return void
 */
	public function testTestCallWorkflowBehavior() {
		$model = 'TestSuiteWorkflowSaveTestModel';

		//データ生成
		$data = array($model => array(
			'id' => null,
			'language_id' => '2',
			'key' => null,
			'status' => '1',
			'content' => 'Add content',
		));

		//テスト実施
		$this->TestSuite->testCallWorkflowBehavior($data);

		//チェック
		$this->assertEquals($model, get_class($this->TestSuite->$model));
	}

/**
 * testCallWorkflowBehavior()のテスト(ExceptionError)
 *
 * @return void
 */
	public function testTestCallWorkflowBehaviorOnExceptionError() {
		$model = 'TestSuiteWorkflowSaveTestModel';

		//データ生成
		$data = array($model => array(
			'id' => null,
			'language_id' => '2',
			'key' => null,
			'status' => '1',
			'content' => 'Add content',
		));

		//テスト実施
		$this->setExpectedException('CakeException');
		$this->TestSuite->testCallWorkflowBehaviorOnExceptionError($data);
	}

}
