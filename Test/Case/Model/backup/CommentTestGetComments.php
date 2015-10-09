<?php
/**
 * Test Case of WorkflowComment->getComments()
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CommentsModelTestBase', 'Workflow.Test/Case/Model');

/**
 * Test Case of WorkflowComment->getComments()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model
 */
class CommentTestGetComments extends CommentsModelTestBase {

/**
 * Expect to get the comments
 *
 * @return  void
 */
	public function test() {
		////テスト実行
		//$conditions = array(
		//	'plugin_key' => 'test_plugin',
		//	'content_key' => 'test_content',
		//);
		//$result = $this->WorkflowComment->getComments($conditions);
		//
		////期待値セット
		//$expected = array(0 => array(
		//	'WorkflowComment' => array(
		//		'id' => '1',
		//		'plugin_key' => 'test_plugin',
		//		'block_key' => 'test_block_key',
		//		'content_key' => 'test_content',
		//		'comment' => 'comment data'
		//	),
		//));
		//
		////チェック
		//$this->assertEquals(1, count($result));
		//
		//$this->_assertArray($expected, $result);
	}

}
