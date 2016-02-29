<?php
/**
 * WorkflowControllerViewTestテスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowControllerViewTest', 'Workflow.TestSuite');

/**
 * WorkflowControllerViewTestテスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\TestSuite
 */
class TestSuiteWorkflowControllerViewTest extends WorkflowControllerViewTest {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'test_workflow';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'TestSuiteWorkflowControllerViewTest';

/**
 * viewアクションのテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderView
 * @return mixed テスト結果
 */
	public function testView($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerViewTest');
		parent::testView($urlOptions, $assert, $exception, $return);
		return $this;
	}

/**
 * viewアクションのテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderViewByCreatable
 * @return mixed テスト結果
 */
	public function testViewByCreatable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerViewTest');
		parent::testViewByCreatable($urlOptions, $assert, $exception, $return);
		return $this;
	}

/**
 * viewアクションのテスト(編集権限、公開権限なし)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderViewByEditable
 * @return mixed テスト結果
 */
	public function testViewByEditable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerViewTest');
		parent::testViewByEditable($urlOptions, $assert, $exception, $return);
		return $this;
	}

}
