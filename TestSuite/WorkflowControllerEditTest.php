<?php
/**
 * WorkflowControllerViewTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * WorkflowControllerViewTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\TestSuite
 */
class WorkflowControllerEditTest extends NetCommonsControllerTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->generateNc(Inflector::camelize($this->_controller));
	}

/**
 * editアクションのGETテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param bool $hasDelete 削除ボタン(リンク)の有無
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGet
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testEditGet($urlOptions, $assert, $hasDelete = false, $exception = null, $return = 'contents') {
		if ($exception && $return !== 'json') {
			$this->setExpectedException($exception);
		}
		$asserts = array();
		if ($assert) {
			$asserts[] = $assert;
		}

		//URL設定
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
		), $urlOptions);
		$params = array(
			'method' => 'get',
			'return' => 'view'
		);
		if ($return === 'json') {
			$params['type'] = 'json';
		}

		//テスト実施
		$this->testAction(NetCommonsUrl::actionUrl($url), $params);
		if ($return === 'view') {
			$result = $this->controller->view;
		} else {
			$result = $this->contents;
		}
		if ($exception) {
			if ($return === 'json') {
				$result = json_decode($this->contents, true);
				$this->assertArrayHasKey('code', $result);
				$this->assertEquals(400, $result['code']);
			}
			return;
		}

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
			$asserts[] = $assert;
		}

		//チェック
		$this->asserts($asserts, $result);
	}

/**
 * editアクションのGETテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param bool $hasDelete 削除ボタン(リンク)の有無
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGetByCreatable
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testEditGetByCreatable($urlOptions, $assert, $hasDelete = false, $exception = null, $return = 'contents') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testEditGet($urlOptions, $assert, $hasDelete, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * editアクションのGETテスト(編集権限、公開権限なし)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param bool $hasDelete 削除ボタン(リンク)の有無
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGetByEditable
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testEditGetByEditable($urlOptions, $assert, $hasDelete = false, $exception = null, $return = 'contents') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_EDITOR);

		$this->testEditGet($urlOptions, $assert, $hasDelete, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * editアクションのGETテスト(公開権限あり)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param bool $hasDelete 削除ボタン(リンク)の有無
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGetByPublishable
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testEditGetByPublishable($urlOptions, $assert, $hasDelete = false, $exception = null, $return = 'contents') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);

		$this->testEditGet($urlOptions, $assert, $hasDelete, $exception, $return);

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
	public function testEditPost($data, $role, $urlOptions, $exception = null, $return = 'contents') {
		if ($exception && $return !== 'json') {
			$this->setExpectedException($exception);
		}
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//URL設定
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
		), $urlOptions);
		$params = array(
			'method' => 'put',
			'return' => 'view',
			'data' => $data
		);
		if ($return === 'json') {
			$params['type'] = 'json';
		}

		//テスト実施
		$this->testAction(NetCommonsUrl::actionUrl($url), $params);
		if ($exception) {
			if ($return === 'json') {
				$result = json_decode($this->contents, true);
				$this->assertArrayHasKey('code', $result);
				$this->assertEquals(400, $result['code']);
			}
			return;
		}

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
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}
		$data = Hash::remove($data, $validationError['field']);
		$data = Hash::insert($data, $validationError['field'], $validationError['value']);

		//URL設定
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
		), $urlOptions);
		$params = array(
			'method' => 'put',
			'return' => 'view',
			'data' => $data
		);

		//テスト実施
		$this->testAction(NetCommonsUrl::actionUrl($url), $params);

		//バリデーションエラー
		$asserts = array(
			array('method' => 'assertNotEmpty', 'value' => $this->controller->validationErrors),
			array('method' => 'assertTextContains', 'expected' => $validationError['message']),
		);

		//チェック
		$this->asserts($asserts, $this->contents);

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}

}
