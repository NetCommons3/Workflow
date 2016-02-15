<?php
/**
 * WorkflowControllerDeleteTest::testDeleteGet()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowControllerDeleteTest::testDeleteGet()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\TestSuite\WorkflowControllerDeleteTest
 */
class TestSuiteWorkflowControllerDeleteTestTestDeleteGetTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteWorkflowControllerDeleteTest', 'TestWorkflow.TestSuite');
		$this->TestSuite = new TestSuiteWorkflowControllerDeleteTest();
	}

/**
 * testDeleteGet()のテスト
 *
 * @return void
 */
	public function testTestDeleteGet() {
		//データ生成
		$role = Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR;
		$urlOptions = array();
		$assert = array('method' => 'assertNotEmpty');
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testDeleteGet($role, $urlOptions, $assert, $exception, $return);

		//チェック
		$pattern = '/' . preg_quote('TestSuite/WorkflowControllerDeleteTest/delete.ctp', '/') . '/';
		$this->assertRegExp($pattern, $result->view);
	}

}
