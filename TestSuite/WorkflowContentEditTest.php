<?php
/**
 * WorkflowContentEditTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */


/**
 * WorkflowContentEditTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AuthGeneral\TestSuite
 */
interface WorkflowContentEditTest {

/**
 * edit()のGETパラメータのテスト(ログインなし)
 *
 * @return void
 */
	public function testEditGet();

/**
 * edit()のGETパラメータのテスト(作成権限あり)
 *
 * @return void
 */
	public function testEditGetByCreatable();

/**
 * edit()のGETパラメータのテスト(編集権限あり)
 *
 * @return void
 */
	public function testEditGetByEditable();

/**
 * edit()のGETパラメータのテスト(公開権限あり)
 *
 * @return void
 */
	public function testEditGetByPublishable();

/**
 * edit()のPOST or PUTパラメータのテスト(ログインなし)
 *
 * @return void
 */
	public function testEditPost();

/**
 * edit()のPOST or PUTパラメータのテスト(作成権限あり)
 *
 * @return void
 */
	public function testEditPostByCreatable();

/**
 * edit()のPOST or PUTパラメータのテスト(編集権限あり)
 *
 * @return void
 */
	public function testEditPostByEditable();

/**
 * edit()のPOST or PUTパラメータのテスト(公開権限あり)
 *
 * @return void
 */
	public function testEditPostByPublishable();

}
