<?php
/**
 * Test Case of WorkflowComment->deleteByBlockKey()
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CommentsModelTestBase', 'Workflow.Test/Case/Model');

/**
 * Test Case of WorkflowComment->deleteByBlockKey()
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
		//$result = $this->WorkflowComment->deleteByBlockKey($blockKey);
		//$this->assertTrue($result);
		//
		////チェック
		//$conditions = array(
		//	'plugin_key' => 'test_plugin',
		//	'content_key' => 'test_content',
		//);
		//$result = $this->WorkflowComment->getComments($conditions);
		//
		//$this->assertEquals(0, count($result));
	}

/**
 * Expect to fail on WorkflowComment->deleteAll()
 * e.g.) connection error
 *
 * @return  void
 */
	public function testFailOnDeleteAll() {
		//$this->setExpectedException('InternalErrorException');
		//
		//$blockKey = 'test_block_key';
		//
		//$this->WorkflowComment = $this->getMockForModel('Workflow.WorkflowComment', array('deleteAll'));
		//$this->WorkflowComment->expects($this->any())
		//	->method('deleteAll')
		//	->will($this->returnValue(false));
		//
		////実施
		//$this->WorkflowComment->deleteByBlockKey($blockKey);
	}

}
