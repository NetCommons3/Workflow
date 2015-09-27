<?php
/**
 * WorkflowContentEditPostTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * WorkflowContentEditPostTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AuthGeneral\TestSuite
 */
interface WorkflowContentEditPostTest {

/**
 * edit()のPUT(POST)パラメータのテスト(ログインなし)
 *
 * @return void
 */
	public function testEditPost();

/**
 * edit()のPUT(POST)パラメータのテスト(作成権限あり)
 *
 * @return void
 */
	public function testEditPostByCreatable();

/**
 * edit()のPUT(POST)パラメータのテスト(編集権限あり)
 *
 * @return void
 */
	public function testEditPostByEditable();

/**
 * edit()のPUT(POST)パラメータのテスト(公開権限あり)
 *
 * @return void
 */
	public function testEditPostByPublishable();

/**
 * edit()のPUT(POST)パラメータのValidationErrorテスト
 *
 * @return void
 */
	public function testEditPostValidationError();

}
