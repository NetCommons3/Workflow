<?php
/**
 * WorkflowHelper::canDelete()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowHelper::canDelete()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\View\Helper\WorkflowHelper
 */
class WorkflowHelperCanDeleteTest extends NetCommonsHelperTestCase {

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
				array('canDeleteWorkflowContent'))
				->expects($this->once())
				->method('canDeleteWorkflowContent')
				->will($this->returnValue(true));
	}

/**
 * canDelete()のテスト
 *
 * @return void
 */
	public function testCanDelete() {
		//Helperロード
		$viewVars = array();
		$requestData = array();
		$params = array();
		$this->loadHelper('Workflow.Workflow', $viewVars, $requestData, $params);

		//データ生成
		$model = 'TestWorkflow.TestViewHelperWorkflowHelperModel';
		$data = array();

		//テスト実施
		$result = $this->Workflow->canDelete($model, $data);

		//チェック
		$this->assertTrue($result);
	}

/**
 * canDelete()のテスト(プラグイン名指定なし)
 *
 * @return void
 */
	public function testCanDeleteWithoutPluginName() {
		//Helperロード
		$viewVars = array();
		$requestData = array();
		$params = array('plugin' => 'TestWorkflow');
		$this->loadHelper('Workflow.Workflow', $viewVars, $requestData, $params);

		//データ生成
		$model = 'TestViewHelperWorkflowHelperModel';
		$data = array();

		//テスト実施
		$result = $this->Workflow->canDelete($model, $data);

		//チェック
		$this->assertTrue($result);
	}

}
