<?php
/**
 * WorkflowSaveTest::setUp()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowSaveTest::setUp()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowSaveTest
 */
class TestSuiteWorkflowSaveTestSetUpTest extends NetCommonsCakeTestCase {

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
 * setUp()のテスト
 *
 * @return void
 */
	public function testSetUp() {
		//テスト実施
		$this->TestSuite->setUp();

		//チェック
		$this->assertEquals('2', Current::read('Block.id'));
		$this->assertEquals('1', Current::read('Room.id'));
		$this->assertTrue(Current::permission('content_editable'));
		$this->assertTrue(Current::permission('content_publishable'));
	}

}
