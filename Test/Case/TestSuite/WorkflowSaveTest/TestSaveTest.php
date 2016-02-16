<?php
/**
 * WorkflowSaveTest::testSave()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowSaveTest::testSave()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowSaveTest
 */
class TestSuiteWorkflowSaveTestTestSaveTest extends NetCommonsCakeTestCase {

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
 * testSave()のテスト(新規処理)
 *
 * @return void
 */
	public function testTestSaveByInsert() {
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
		$result = $this->TestSuite->testSave($data);
		$result = Hash::remove($result, '{s}.created');
		$result = Hash::remove($result, '{s}.created_user');
		$result = Hash::remove($result, '{s}.modified');
		$result = Hash::remove($result, '{s}.modified_user');

		//チェック
		$actual = Hash::merge($data, array($model => array(
			'id' => '3',
			'key' => OriginalKeyBehavior::generateKey($this->TestSuite->$model->name, $this->TestSuite->$model->useDbConfig),
			'is_active' => true,
			'is_latest' => true,
		)));
		$this->assertEquals($actual, $result);
	}

/**
 * testSave()のテスト(更新処理)
 *
 * @return void
 */
	public function testTestSaveByUpdate() {
		$model = 'TestSuiteWorkflowSaveTestModel';

		//データ生成
		$data = array('TestSuiteWorkflowSaveTestModel' => array(
			'id' => '1',
			'language_id' => '2',
			'key' => 'not_publish_key',
			'status' => '1',
			'content' => 'Edit content',
		));

		//テスト実施
		$result = $this->TestSuite->testSave($data);
		$result = Hash::remove($result, '{s}.created');
		$result = Hash::remove($result, '{s}.created_user');
		$result = Hash::remove($result, '{s}.modified');
		$result = Hash::remove($result, '{s}.modified_user');

		//チェック
		$actual = Hash::merge($data, array($model => array(
			'id' => '3',
			'is_active' => true,
			'is_latest' => true,
		)));
		$this->assertEquals($actual, $result);
	}

}
