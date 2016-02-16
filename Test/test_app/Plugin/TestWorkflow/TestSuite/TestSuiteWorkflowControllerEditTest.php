<?php
/**
 * WorkflowControllerEditTestテスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowControllerEditTest', 'Workflow.TestSuite');

/**
 * WorkflowControllerEditTestテスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\TestSuite
 */
class TestSuiteWorkflowControllerEditTest extends WorkflowControllerEditTest {

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
	protected $_controller = 'TestSuiteWorkflowControllerEditTest';

/**
 * editアクションのGETテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGet
 * @return mixed テスト結果
 */
	public function testEditGet($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerEditTest');
		parent::testEditGet($urlOptions, $assert, $exception, $return);
		return $this;
	}

/**
 * editアクションのGETテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGetByCreatable
 * @return mixed テスト結果
 */
	public function testEditGetByCreatable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerEditTest');
		parent::testEditGetByCreatable($urlOptions, $assert, $exception, $return);
		return $this;
	}

/**
 * editアクションのGETテスト(編集権限、公開権限なし)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGetByEditable
 * @return mixed テスト結果
 */
	public function testEditGetByEditable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerEditTest');
		parent::testEditGetByEditable($urlOptions, $assert, $exception, $return);
		return $this;
	}

/**
 * editアクションのGETテスト(公開権限あり)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGetByPublishable
 * @return mixed テスト結果
 */
	public function testEditGetByPublishable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerEditTest');
		parent::testEditGetByPublishable($urlOptions, $assert, $exception, $return);
		return $this;
	}

/**
 * editアクションのPOSTテスト
 *
 * @param array $data POSTデータ
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditPost
 * @return mixed テスト結果
 */
	public function testEditPost($data, $role, $urlOptions, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerEditTest');
		parent::testEditPost($data, $role, $urlOptions, $exception, $return);
		return $this;
	}

/**
 * editアクションのValidateionErrorテスト
 *
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string|null $validationError ValidationError
 * @dataProvider dataProviderEditValidationError
 * @return mixed テスト結果
 */
	public function testEditValidationError($data, $urlOptions, $validationError = null) {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerEditTest');
		parent::testEditValidationError($data, $urlOptions, $validationError);
		return $this;
	}

}
