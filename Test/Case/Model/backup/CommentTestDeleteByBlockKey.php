<?php
/**
 * Test Case of Comment->deleteByBlockKey()
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CommentsModelTestBase', 'Workflow.Test/Case/Model');

/**
 * Test Case of Comment->deleteByBlockKey()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model
 */
class CommentTestCommentTestDeleteByBlockKey extends CommentsModelTestBase {

/**
 * Expect to delete the comments by blocks.key
 *
 * @return  void
 */
	public function testByBlockKey() {
		////テスト実行
		//$blockKey = 'test_block_key';
		//$result = $this->Comment->deleteByBlockKey($blockKey);
		//$this->assertTrue($result);
		//
		////チェック
		//$conditions = array(
		//	'plugin_key' => 'test_plugin',
		//	'content_key' => 'test_content',
		//);
		//$result = $this->Comment->getComments($conditions);
		//
		//$this->assertEquals(0, count($result));
	}

/**
 * Expect to fail on Comment->deleteAll()
 * e.g.) connection error
 *
 * @return  void
 */
	public function testFailOnDeleteAll() {
		//$this->setExpectedException('InternalErrorException');
		//
		//$blockKey = 'test_block_key';
		//
		//$this->Comment = $this->getMockForModel('Workflow.Comment', array('deleteAll'));
		//$this->Comment->expects($this->any())
		//	->method('deleteAll')
		//	->will($this->returnValue(false));
		//
		////実施
		//$this->Comment->deleteByBlockKey($blockKey);
	}

}
