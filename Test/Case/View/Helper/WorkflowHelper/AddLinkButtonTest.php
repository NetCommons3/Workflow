<?php
/**
 * WorkflowHelper::addLinkButton()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowHelper::addLinkButton()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\View\Helper\WorkflowHelper
 */
class WorkflowHelperAddLinkButtonTest extends NetCommonsHelperTestCase {

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

		Current::write('Block.id', '1');
		Current::write('Frame.id', '2');
	}

/**
 * addLinkButton()のテスト
 *
 * @return void
 */
	public function testAddLinkButton() {
		//テストデータ生成
		$title = 'Title';
		$url = array('action' => 'workflow_add');
		$options = array();
		Current::write('Room.id', '2');
		Current::writePermission('2', 'content_creatable', true);

		//Helperロード
		$params = array('plugin' => 'workflow_plugin', 'controller' => 'workflow_controller');
		$this->loadHelper('Workflow.Workflow', array(), array(), $params);

		//テスト実施
		$result = $this->Workflow->addLinkButton($title, $url, $options);

		//チェック
		$expected = '<a href="/workflow_plugin/workflow_controller/' . $url['action'] . '" class="btn btn-success nc-btn-style">' .
						'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <span class="hidden-xs">' . $title . '</span>' .
					'</a>';
		$this->assertEquals($expected, $result);
	}

/**
 * addLinkButton()のテスト(URL指定なし)
 *
 * @return void
 */
	public function testWithoutUrl() {
		//テストデータ生成
		$title = 'Title';
		$url = null;
		$options = array();
		Current::write('Room.id', '2');
		Current::writePermission('2', 'content_creatable', true);

		//Helperロード
		$params = array('plugin' => 'workflow_plugin', 'controller' => 'workflow_controller');
		$this->loadHelper('Workflow.Workflow', array(), array(), $params);

		//テスト実施
		$result = $this->Workflow->addLinkButton($title, $url, $options);

		//チェック
		$expected = '<a href="/workflow_plugin/workflow_controller/add/1?frame_id=2" class="btn btn-success nc-btn-style">' .
						'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <span class="hidden-xs">' . $title . '</span>' .
					'</a>';
		$this->assertEquals($expected, $result);
	}

/**
 * addLinkButton()のテスト(コンテンツ作成権限なし)
 *
 * @return void
 */
	public function testWithoutContentCreatable() {
		//テストデータ生成
		$title = 'Title';
		$url = null;
		$options = array();
		Current::write('Room.id', '2');
		Current::writePermission('2', 'content_creatable', false);

		//Helperロード
		$params = array('plugin' => 'workflow_plugin', 'controller' => 'workflow_controller');
		$this->loadHelper('Workflow.Workflow', array(), array(), $params);

		//テスト実施
		$result = $this->Workflow->addLinkButton($title, $url, $options);

		//チェック
		$expected = '';
		$this->assertEquals($expected, $result);
	}

/**
 * addLinkButton()のテスト(addActionController指定)
 *
 * @return void
 */
	public function testWithAddActionController() {
		//テストデータ生成
		$title = 'Title';
		$url = null;
		$options = array();
		Current::write('Room.id', '2');
		Current::writePermission('2', 'content_creatable', true);

		//Helperロード
		$viewVars = array('addActionController' => 'add_workflow_controller');
		$params = array('plugin' => 'workflow_plugin', 'controller' => 'workflow_controller');
		$this->loadHelper('Workflow.Workflow', $viewVars, array(), $params);

		//テスト実施
		$result = $this->Workflow->addLinkButton($title, $url, $options);

		//チェック
		$expected = '<a href="/workflow_plugin/add_workflow_controller/add/1?frame_id=2" class="btn btn-success nc-btn-style">' .
						'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <span class="hidden-xs">' . $title . '</span>' .
					'</a>';
		$this->assertEquals($expected, $result);
	}

}
