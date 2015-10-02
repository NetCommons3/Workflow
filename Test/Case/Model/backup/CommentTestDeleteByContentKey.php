<?php
/**
 * Test Case of WorkflowComment->deleteByContentKey()
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CommentsModelTestBase', 'Workflow.Test/Case/Model');

/**
 * Test Case of WorkflowComment->deleteByContentKey()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model
 */
class CommentTestDeleteByContentKey extends CommentsModelTestBase {

/**
 * Expect to delete the comments by blocks.key
 *
 * @return  void
 */
	public function testByContentKey() {
		////テスト実行
		//$contentKey = 'test_content';
		//$result = $this->WorkflowComment->deleteByContentKey($contentKey);
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
		//$contentKey = 'test_content';
		//
		//$this->WorkflowComment = $this->getMockForModel('Workflow.WorkflowComment', array('deleteAll'));
		//$this->WorkflowComment->expects($this->any())
		//	->method('deleteAll')
		//	->will($this->returnValue(false));
		//
		////実施
		//$this->WorkflowComment->deleteByContentKey($contentKey);
	}

}
