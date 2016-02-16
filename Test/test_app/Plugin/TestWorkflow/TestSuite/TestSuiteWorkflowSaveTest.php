<?php
/**
 * WorkflowSaveTestテスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowSaveTest', 'Workflow.TestSuite');

/**
 * WorkflowSaveTestテスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\TestSuite
 */
class TestSuiteWorkflowSaveTest extends WorkflowSaveTest {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'test_workflow';

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName = 'TestSuiteWorkflowSaveTestModel';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'save';

/**
 * setUp method
 *
 * @return mixed テスト結果
 */
	public function setUp() {
		return parent::setUp();
	}

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return mixed テスト結果
 */
	public function testSave($data) {
		$this->setUp();

		$model = $this->_modelName;
		$this->$model = ClassRegistry::init(Inflector::camelize($this->plugin) . '.' . $model);
		return parent::testSave($data);
	}

/**
 * Test to call WorkflowBehavior::beforeSave
 *
 * WorkflowBehaviorをモックに置き換えて登録処理を呼び出します。<br>
 * WorkflowBehavior::beforeSaveが1回呼び出されることをテストします。<br>
 * ##### 参考URL
 * http://stackoverflow.com/questions/19833495/how-to-mock-a-cakephp-behavior-for-unit-testing]
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return mixed テスト結果
 */
	public function testCallWorkflowBehavior($data) {
		$this->setUp();

		$model = $this->_modelName;
		$this->$model = ClassRegistry::init(Inflector::camelize($this->plugin) . '.' . $model);
		return parent::testCallWorkflowBehavior($data);
	}

/**
 * Test to call WorkflowBehavior::beforeSave
 *
 * WorkflowBehaviorをモックに置き換えて登録処理を呼び出します。<br>
 * WorkflowBehavior::beforeSaveが1回呼び出されることをテストします。<br>
 * ##### 参考URL
 * http://stackoverflow.com/questions/19833495/how-to-mock-a-cakephp-behavior-for-unit-testing]
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return mixed テスト結果
 */
	public function testCallWorkflowBehaviorOnExceptionError($data) {
		$this->setUp();

		$model = $this->_modelName;
		$this->$model = ClassRegistry::init(Inflector::camelize($this->plugin) . '.' . $model);

		$this->$model->Behaviors->unload('Workflow.Workflow');
		unset($this->$model->actsAs['Workflow.Workflow']);

		return parent::testCallWorkflowBehavior($data);
	}

}
