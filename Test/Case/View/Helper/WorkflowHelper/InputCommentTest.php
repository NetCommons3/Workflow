<?php
/**
 * WorkflowHelper::inputComment()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowHelper::inputComment()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\View\Helper\WorkflowHelper
 */
class WorkflowHelperInputCommentTest extends NetCommonsHelperTestCase {

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

		//テストデータ生成
		Current::$current = Hash::insert(Current::$current, 'Permission.content_publishable.value', true);
		Current::$current = Hash::insert(Current::$current, 'Block.key', 'block_1');

		$viewVars = array();
		$requestData = array(
			'Workflow' => array('status' => '1')
		);

		//Helperロード
		$this->loadHelper('Workflow.Workflow', $viewVars, $requestData);
	}

/**
 * inputComment()のテスト
 *
 * @return void
 */
	public function testInputComment() {
		//データ生成
		$statusFieldName = 'Workflow.status';
		$displayBlockKey = true;

		//テスト実施
		$result = $this->Workflow->inputComment($statusFieldName, $displayBlockKey);

		//チェック
		$this->assertTextContains('data[WorkflowComment][comment]', $result);
		$this->assertTextContains('<input type="hidden" name="data[Block][key]" value="block_1"', $result);
	}

/**
 * inputComment()のテスト(block_keyなし)
 *
 * @return void
 */
	public function testInputCommentWithoutBlockKey() {
		//データ生成
		$statusFieldName = 'Workflow.status';
		$displayBlockKey = false;

		//テスト実施
		$result = $this->Workflow->inputComment($statusFieldName, $displayBlockKey);

		//チェック
		$this->assertTextContains('data[WorkflowComment][comment]', $result);
		$this->assertTextNotContains('<input type="hidden" name="data[Block][key]" value="block_1"', $result);
	}

}
