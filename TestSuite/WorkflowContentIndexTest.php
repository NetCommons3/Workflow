<?php
/**
 * WorkflowContentIndexTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * WorkflowContentIndexTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AuthGeneral\TestSuite
 */
interface WorkflowContentIndexTest {

/**
 * index()のテスト(ログインなし)
 *
 * @return void
 */
	public function testIndex();

/**
 * index()のテスト(作成権限あり)
 *
 * @return void
 */
	public function testIndexByCreatable();

/**
 * index()のテスト(編集権限あり)
 *
 * @return void
 */
	public function testIndexByEditable();

}
