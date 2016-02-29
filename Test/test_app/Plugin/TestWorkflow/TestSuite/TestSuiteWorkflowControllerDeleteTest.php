<?php
/**
 * WorkflowControllerDeleteTestテスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowControllerDeleteTest', 'Workflow.TestSuite');

/**
 * WorkflowControllerDeleteTestテスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\TestSuite
 */
class TestSuiteWorkflowControllerDeleteTest extends WorkflowControllerDeleteTest {

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
	protected $_controller = 'TestSuiteWorkflowControllerDeleteTest';

/**
 * deleteアクションのGETテスト
 *
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDeleteGet
 * @return mixed テスト結果
 */
	public function testDeleteGet($role, $urlOptions, $assert, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerDeleteTest');
		parent::testDeleteGet($role, $urlOptions, $assert, $exception, $return);
		return $this;
	}

/**
 * deleteアクションのExceptionErrorテスト
 *
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDeleteExceptionError
 * @return mixed テスト結果
 */
	public function testDeleteExceptionError($mockModel, $mockMethod, $data, $urlOptions, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerDeleteTest');
		parent::testDeleteExceptionError($mockModel, $mockMethod, $data, $urlOptions, $exception, $return);
		return $this;
	}

/**
 * deleteアクションのPOSTテスト
 *
 * @param array $data POSTデータ
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDeletePost
 * @return mixed テスト結果
 */
	public function testDeletePost($data, $role, $urlOptions, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestSuiteWorkflowControllerDeleteTest');
		parent::testDeletePost($data, $role, $urlOptions, $exception, $return);
		return $this;
	}

}
