<?php
/**
 * WorkflowControllerViewTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerEditTest', 'NetCommons.TestSuite');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * WorkflowControllerViewTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\TestSuite
 */
class WorkflowControllerEditTest extends NetCommonsControllerEditTest {

/**
 * editアクションのGETテスト
 *
 * @param bool $hasDelete 削除ボタン(リンク)の有無
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGet
 * @return void
 */
	public function testEditGet($hasDelete, $urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
		), $urlOptions);
		$result = parent::testEditGet($url, $assert, $exception, $return);

		//削除ボタン(リンク)のチェック
		if (isset($hasDelete)) {
			$deleteUrl = $url;
			$deleteUrl['action'] = 'delete';
			if (! Current::read('Frame.id')) {
				unset($deleteUrl['frame_id']);
			}
			if (! Current::read('Block.id')) {
				unset($deleteUrl['block_id']);
			}
			$assert = array();
			if ($hasDelete) {
				$assert['method'] = 'assertRegExp';
			} else {
				$assert['method'] = 'assertNotRegExp';
			}
			$assert['expected'] = '/' . preg_quote(NetCommonsUrl::actionUrl($deleteUrl), '/') . '/';

			//チェック
			$this->asserts(array($assert), $result);
		}
	}

/**
 * editアクションのGETテスト(作成権限のみ)
 *
 * @param bool $hasDelete 削除ボタン(リンク)の有無
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGetByCreatable
 * @return void
 */
	public function testEditGetByCreatable($hasDelete, $urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testEditGet($hasDelete, $urlOptions, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * editアクションのGETテスト(編集権限、公開権限なし)
 *
 * @param bool $hasDelete 削除ボタン(リンク)の有無
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGetByEditable
 * @return void
 */
	public function testEditGetByEditable($hasDelete, $urlOptions, $assert, $exception = null, $return = 'contents') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_EDITOR);

		$this->testEditGet($hasDelete, $urlOptions, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * editアクションのGETテスト(公開権限あり)
 *
 * @param bool $hasDelete 削除ボタン(リンク)の有無
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGetByPublishable
 * @return void
 */
	public function testEditGetByPublishable($hasDelete, $urlOptions, $assert, $exception = null, $return = 'contents') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);

		$this->testEditGet($hasDelete, $urlOptions, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
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
 * @return void
 */
	public function testEditPost($data, $role, $urlOptions, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実施
		parent::testEditPost($data, Hash::merge(array('action' => 'edit'), $urlOptions), $exception, $return);

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

/**
 * editアクションのValidateionErrorテスト
 *
 * @param array $data POSTデータ
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param string|null $validationError ValidationError
 * @dataProvider dataProviderEditValidationError
 * @return void
 */
	public function testEditValidationError($data, $role, $urlOptions, $validationError = null) {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実施
		parent::testEditValidationError($data, Hash::merge(array('action' => 'edit'), $urlOptions), $validationError);

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}

}
