<?php
/**
 * WorkflowComponent::startup()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowComponent::startup()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Controller\Component\WorkflowComponent
 */
class WorkflowComponentStartupTest extends NetCommonsControllerTestCase {

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
 * startup()のテスト
 *
 * @return void
 */
	public function testStartup() {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestWorkflowComponent');

		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testNcAction('/test_workflow/test_workflow_component/index', array(
			'method' => 'get'
		));

		//チェック
		$pattern = '/' . preg_quote('Controller/Component/TestWorkflowComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertTrue(in_array('Users.DisplayUser', $this->controller->helpers, true));
	}

}
