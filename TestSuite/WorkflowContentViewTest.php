<?php
/**
 * WorkflowContentViewTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */


/**
 * WorkflowContentViewTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AuthGeneral\TestSuite
 */
interface WorkflowContentViewTest {

/**
 * view()のテスト(ログインなし)
 *
 * @return void
 */
	public function testView();

/**
 * view()のテスト(作成権限あり)
 *
 * @return void
 */
	public function testViewByCreatable();

/**
 * view()のテスト(編集権限あり)
 *
 * @return void
 */
	public function testViewByEditable();

/**
 * view()のコンテンツなしテスト
 *
 * @return void
 */
	public function testViewNoContent();

/**
 * view()のフレーム削除テスト
 *
 * @return void
 */
	public function testViewOnDeleteFrame();

}
