<?php
/**
 * WorkflowComponent::parseStatus()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowComponent::parseStatus()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Controller\Component\WorkflowComponent
 */
class WorkflowComponentParseStatusTest extends NetCommonsControllerTestCase {

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

		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestWorkflowComponent');

		//ログイン
		TestAuthGeneral::login($this);

		//テストアクション実行
		$this->_testGetAction('/test_workflow/test_workflow_component/index',
				array('method' => 'assertNotEmpty'), null, 'view');
		$pattern = '/' . preg_quote('Controller/Component/TestWorkflowComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * parseStatus()のテスト
 *
 * @return void
 */
	public function testParseStatus() {
		//テストデータ
		$this->controller->request->data['save_2'] = null;

		//テスト実行
		$result = $this->controller->Workflow->parseStatus();

		//チェック
		$this->assertEquals('2', $result);
	}

/**
 * parseStatus()のExceptionErrorテスト
 *
 * @return void
 */
	public function testParseStatusOnExceptionError() {
		//テストデータ
		$this->controller->request->data['save_aaa'] = null;
		$this->setExpectedException('BadRequestException');

		//テスト実行
		$this->controller->Workflow->parseStatus();
	}

}
