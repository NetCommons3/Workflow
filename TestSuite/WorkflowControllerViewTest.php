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
class WorkflowControllerViewTest extends NetCommonsControllerTestCase {

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
 * viewアクションのテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param bool $hasEdit 編集ボタン(リンク)の有無
 * @param string $return testActionの実行後の結果
 * @param string|null $exception Exception
 * @dataProvider dataProviderView
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testView($urlOptions, $assert, $hasEdit = false, $return = 'contents', $exception = null) {
		if ($exception) {
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
			'action' => 'view',
		), $urlOptions);
		$params = array(
			'method' => 'get',
			'return' => 'view'
		);

		//テスト実施
		$this->testAction(NetCommonsUrl::actionUrl($url), $params);
		if ($return === 'view') {
			$result = $this->controller->view;
		} else {
			$result = $this->contents;
		}

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
			$asserts[] = $assert;
		}

		//チェック
		$this->asserts($asserts, $result);
	}

/**
 * viewアクションのテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param bool $hasEdit 編集ボタン(リンク)の有無
 * @param string $return testActionの実行後の結果
 * @param string|null $exception Exception
 * @dataProvider dataProviderViewByCreatable
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testViewByCreatable($urlOptions, $assert, $hasEdit = false, $return = 'contents', $exception = null) {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testView($urlOptions, $assert, $hasEdit, $return, $exception);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * viewアクションのテスト(編集権限、公開権限なし)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param bool $hasEdit 編集ボタン(リンク)の有無
 * @param string $return testActionの実行後の結果
 * @param string|null $exception Exception
 * @dataProvider dataProviderViewByEditable
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testViewByEditable($urlOptions, $assert, $hasEdit = false, $return = 'contents', $exception = null) {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_EDITOR);

		$this->testView($urlOptions, $assert, $hasEdit, $return, $exception);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

}
