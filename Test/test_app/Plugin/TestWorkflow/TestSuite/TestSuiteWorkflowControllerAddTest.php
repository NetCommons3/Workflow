<?php
/**
 * WorkflowControllerAddTestテスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowControllerAddTest', 'Workflow.TestSuite');

/**
 * WorkflowControllerAddTestテスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\TestSuite
 */
class TestSuiteWorkflowControllerAddTest extends WorkflowControllerAddTest {

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
	protected $_controller = 'TestSuiteWorkflowControllerAddTest';

/**
 * addアクションのGETテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderAddGet
 * @return mixed テスト結果
 */
	public function testAddGet($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerAddTest');
		parent::testAddGet($urlOptions, $assert, $exception, $return);
		return $this;
	}

/**
 * addアクションのGETテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderAddGetByCreatable
 * @return mixed テスト結果
 */
	public function testAddGetByCreatable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerAddTest');
		parent::testAddGetByCreatable($urlOptions, $assert, $exception, $return);
		return $this;
	}

/**
 * addアクションのPOSTテスト
 *
 * @param array $data POSTデータ
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderAddPost
 * @return mixed テスト結果
 */
	public function testAddPost($data, $role, $urlOptions, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerAddTest');
		parent::testAddPost($data, $role, $urlOptions, $exception, $return);
		return $this;
	}

/**
 * addアクションのValidateionErrorテスト
 *
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string|null $validationError ValidationError
 * @dataProvider dataProviderAddValidationError
 * @return mixed テスト結果
 */
	public function testAddValidationError($data, $urlOptions, $validationError = null) {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerAddTest');
		parent::testAddValidationError($data, $urlOptions, $validationError);
		return $this;
	}

}
