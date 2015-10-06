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
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param array $asserts テストの期待値
 * @param bool $hasEdit 編集ボタン(リンク)の有無
 * @param string $return testActionの実行後の結果
 * @param string|null $exception Exception
 * @dataProvider dataProviderView
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testView($role, $urlOptions, $asserts, $hasEdit = false, $return = 'contents', $exception = null) {
		if ($exception) {
			$this->setExpectedException($exception);
		}
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}
		if (! isset($asserts)) {
			$asserts = array();
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

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}
}
