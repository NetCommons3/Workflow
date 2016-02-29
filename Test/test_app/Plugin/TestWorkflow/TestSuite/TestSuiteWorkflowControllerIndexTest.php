<?php
/**
 * WorkflowControllerIndexTestテスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowControllerIndexTest', 'Workflow.TestSuite');

/**
 * WorkflowControllerIndexTestテスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\TestSuite
 */
class TestSuiteWorkflowControllerIndexTest extends WorkflowControllerIndexTest {

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
	protected $_controller = 'TestSuiteWorkflowControllerIndexTest';

/**
 * indexアクションのテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndex
 * @return mixed テスト結果
 */
	public function testIndex($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerIndexTest');
		parent::testIndex($urlOptions, $assert, $exception, $return);
		return $this;
	}

/**
 * indexアクションのテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndexByCreatable
 * @return mixed テスト結果
 */
	public function testIndexByCreatable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerIndexTest');
		parent::testIndexByCreatable($urlOptions, $assert, $exception, $return);
		return $this;
	}

/**
 * indexアクションのテスト(編集権限あり)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndexByEditable
 * @return mixed テスト結果
 */
	public function testIndexByEditable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerIndexTest');
		parent::testIndexByEditable($urlOptions, $assert, $exception, $return);
		return $this;
	}

}
