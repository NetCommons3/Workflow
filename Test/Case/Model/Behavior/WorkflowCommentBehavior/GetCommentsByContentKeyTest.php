<?php
/**
 * WorkflowCommentBehavior::getCommentsByContentKey()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowCommentBehavior::getCommentsByContentKey()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\Behavior\WorkflowCommentBehavior
 */
class WorkflowCommentBehaviorGetCommentsByContentKeyTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.workflow_comment',
	);

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

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Workflow', 'TestWorkflow');
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowCommentBehaviorModel');
	}

/**
 * getCommentsByContentKey()のテスト
 *
 * @return void
 */
	public function testGetCommentsByContentKey() {
		$contentKey = 'comment_content_1';

		//テスト実施
		$result = $this->TestModel->getCommentsByContentKey($contentKey);

		//チェック
		$this->assertCount(2, $result);

		$index = 0;
		$this->assertEquals(
			array('WorkflowComment', 'TrackableCreator', 'TrackableUpdater'), array_keys($result[$index])
		);
		$this->assertEquals('2', Hash::get($result, $index . '.WorkflowComment.id'));
		$this->assertEquals('workflow', Hash::get($result, $index . '.WorkflowComment.plugin_key'));
		$this->assertEquals('block_1', Hash::get($result, $index . '.WorkflowComment.block_key'));
		$this->assertEquals('comment_content_1', Hash::get($result, $index . '.WorkflowComment.content_key'));
		$this->assertEquals('WorkflowComment data 2', Hash::get($result, $index . '.WorkflowComment.comment'));
		$this->assertEquals(
			array('id', 'handlename'), array_keys($result[$index]['TrackableCreator'])
		);
		$this->assertEquals(
			array('id', 'handlename'), array_keys($result[$index]['TrackableUpdater'])
		);

		$index = 1;
		$this->assertEquals(
			array('WorkflowComment', 'TrackableCreator', 'TrackableUpdater'), array_keys($result[$index])
		);
		$this->assertEquals('1', Hash::get($result, $index . '.WorkflowComment.id'));
		$this->assertEquals('workflow', Hash::get($result, $index . '.WorkflowComment.plugin_key'));
		$this->assertEquals('block_1', Hash::get($result, $index . '.WorkflowComment.block_key'));
		$this->assertEquals('comment_content_1', Hash::get($result, $index . '.WorkflowComment.content_key'));
		$this->assertEquals('WorkflowComment data 1', Hash::get($result, $index . '.WorkflowComment.comment'));
		$this->assertEquals(
			array('id', 'handlename'), array_keys($result[$index]['TrackableCreator'])
		);
		$this->assertEquals(
			array('id', 'handlename'), array_keys($result[$index]['TrackableUpdater'])
		);
	}

/**
 * content_keyなしのテスト
 *
 * @return void
 */
	public function testNotContentKey() {
		$contentKey = '';

		//テスト実施
		$result = $this->TestModel->getCommentsByContentKey($contentKey);

		//チェック
		$this->assertCount(0, $result);
		$this->assertInternalType('array', $result);
	}

}
