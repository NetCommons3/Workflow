<?php
/**
 * WorkflowControllerDeleteTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * WorkflowControllerDeleteTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\TestSuite
 */
class WorkflowControllerDeleteTest extends NetCommonsControllerTestCase {

/**
 * deleteアクションのGETテスト
 *
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDeleteGet
 * @return void
 */
	public function testDeleteGet($role, $urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'delete',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
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
 * @return void
 */
	public function testDeleteExceptionError($mockModel, $mockMethod, $data, $urlOptions,
												$exception = null, $return = 'view') {
		$this->_mockForReturnFalse($mockModel, $mockMethod);
		$this->testDeletePost(
			$data, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR, $urlOptions, $exception, $return
		);
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
 * @return void
 */
	public function testDeletePost($data, $role, $urlOptions, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実施
		$this->_testPostAction(
			'delete', $data, Hash::merge(array('action' => 'delete'), $urlOptions), $exception, $return
		);

		//正常の場合、リダイレクト
		if (! $exception) {
			$header = $this->controller->response->header();
			$this->assertNotEmpty($header['Location']);
		}

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}

}
