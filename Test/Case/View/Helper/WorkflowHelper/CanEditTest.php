<?php
/**
 * WorkflowHelper::canEdit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowHelper::canEdit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\View\Helper\WorkflowHelper
 */
class WorkflowHelperCanEditTest extends NetCommonsHelperTestCase {

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

		$this->getMockForModel('TestWorkflow.TestViewHelperWorkflowHelperModel',
				array('canEditWorkflowContent'))
				->expects($this->once())
				->method('canEditWorkflowContent')
				->will($this->returnValue(true));
	}

/**
 * canEdit()のテスト
 *
 * @return void
 */
	public function testCanEdit() {
		//Helperロード
		$viewVars = array();
		$requestData = array();
		$params = array();
		$this->loadHelper('Workflow.Workflow', $viewVars, $requestData, $params);

		//データ生成
		$model = 'TestWorkflow.TestViewHelperWorkflowHelperModel';
		$data = null;

		//テスト実施
		$result = $this->Workflow->canEdit($model, $data);

		//チェック
		$this->assertTrue($result);
	}

/**
 * canEdit()のテスト(プラグイン名指定なし)
 *
 * @return void
 */
	public function testCanEditWithoutPluginName() {
		//Helperロード
		$viewVars = array();
		$requestData = array();
		$params = array('plugin' => 'TestWorkflow');
		$this->loadHelper('Workflow.Workflow', $viewVars, $requestData, $params);

		//データ生成
		$model = 'TestViewHelperWorkflowHelperModel';
		$data = array();

		//テスト実施
		$result = $this->Workflow->canEdit($model, $data);

		//チェック
		$this->assertTrue($result);
	}

}
