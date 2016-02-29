<?php
/**
 * View/Elements/indexのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/indexのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\View\Elements\Index
 */
class WorkflowViewElementsIndexTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'workflow';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Workflow', 'TestWorkflow');
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestViewElementsIndex');
		//ログイン
		TestAuthGeneral::login($this);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);
		parent::tearDown();
	}

/**
 * viewのアサーション
 *
 * @return void
 */
	private function __assertIndex($assert) {
		$this->$assert('ng-click="showUser(\'0\')"', $this->view);
		$this->$assert('ng-click="showUser(\'1\')"', $this->view);
		$this->$assert('ng-click="showUser(\'2\')"', $this->view);
		$this->$assert('Handle name0', $this->view);
		$this->$assert('Handle name1', $this->view);
		$this->$assert('Handle name2', $this->view);
		$this->$assert('/users/users/download/0/avatar/thumb', $this->view);
		$this->$assert('/users/users/download/1/avatar/thumb', $this->view);
		$this->$assert('/users/users/download/2/avatar/thumb', $this->view);
		$this->$assert('Workflow Comment0', $this->view);
		$this->$assert('Workflow Comment1', $this->view);
		$this->$assert('Workflow Comment2', $this->view);
	}

/**
 * View/Elements/indexのテスト
 *
 * @return void
 */
	public function testIndex() {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction('/test_workflow/test_view_elements_index/index',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/index', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
		$this->__assertIndex('assertTextContains');
		$this->assertTextNotContains('ng-click="more=true"', $this->view);
	}

/**
 * View/Elements/indexのテスト(コメントなし)
 *
 * @return void
 */
	public function testNoComment() {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction('/test_workflow/test_view_elements_index/index_no_comment',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/index', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
		$this->__assertIndex('assertTextNotContains');
	}

/**
 * View/Elements/indexのテスト(もっとを表示)
 *
 * @return void
 */
	public function testPaginator() {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction('/test_workflow/test_view_elements_index/index_paginator',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/index', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
		$this->__assertIndex('assertTextContains');
		$this->assertTextContains('ng-click="more=true"', $this->view);
	}

}
