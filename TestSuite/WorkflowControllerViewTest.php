<?php
/**
 * WorkflowControllerViewTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerViewTest', 'NetCommons.TestSuite');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * WorkflowControllerViewTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\TestSuite
 */
class WorkflowControllerViewTest extends NetCommonsControllerViewTest {

/**
 * viewアクションのテスト
 *
 * @param bool $hasEdit 編集ボタン(リンク)の有無
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderView
 * @return void
 */
	public function testView($hasEdit, $urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'view',
		), $urlOptions);
		$result = parent::testView($url, $assert, $exception, $return);

		//編集ボタン(リンク)のチェック
		if (isset($hasEdit)) {
			$editUrl = $url;
			$editUrl['action'] = 'edit';
			if (! Current::read('Frame.id')) {
				unset($editUrl['frame_id']);
			}
			if (! Current::read('Block.id')) {
				unset($editUrl['block_id']);
			}
			$assert = array();
			if ($hasEdit) {
				$assert['method'] = 'assertRegExp';
			} else {
				$assert['method'] = 'assertNotRegExp';
			}
			$assert['expected'] = '/' . preg_quote(NetCommonsUrl::actionUrl($editUrl), '/') . '/';

			//チェック
			$this->asserts(array($assert), $result);
		}

	}

/**
 * viewアクションのテスト(作成権限のみ)
 *
 * @param bool $hasEdit 編集ボタン(リンク)の有無
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderViewByCreatable
 * @return void
 */
	public function testViewByCreatable($hasEdit, $urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testView($hasEdit, $urlOptions, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * viewアクションのテスト(編集権限、公開権限なし)
 *
 * @param bool $hasEdit 編集ボタン(リンク)の有無
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderViewByEditable
 * @return void
 */
	public function testViewByEditable($hasEdit, $urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_EDITOR);

		$this->testView($hasEdit, $urlOptions, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

}
