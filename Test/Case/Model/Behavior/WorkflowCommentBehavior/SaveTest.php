<?php
/**
 * WorkflowCommentBehavior::save()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TestWorkflowCommentBehaviorSaveModelFixture', 'Workflow.Test/Fixture');

/**
 * WorkflowCommentBehavior::save()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\Behavior\WorkflowCommentBehavior
 */
class WorkflowCommentBehaviorSaveTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.workflow_comment',
		'plugin.workflow.test_workflow_comment_behavior_save_model',
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
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowCommentBehaviorSaveModel');
	}

/**
 * save()のテスト
 *
 * @return void
 */
	public function testSave() {
		//テストデータ
		$data = array(
			'TestWorkflowCommentBehaviorSaveModel' => array(
				'key' => 'new_publish_key',
				'status' => '2'
			),
			'Block' => array(
				'key' => 'block_key'
			),
			'WorkflowComment' => array(
				'comment' => 'Workflow Comment'
			)
		);

		//テスト実施
		$result = $this->TestModel->save($data);
		$this->assertDatetime(Hash::get($result, 'TestWorkflowCommentBehaviorSaveModel.created'));
		$this->assertDatetime(Hash::get($result, 'TestWorkflowCommentBehaviorSaveModel.modified'));
		$result = Hash::remove($result, 'TestWorkflowCommentBehaviorSaveModel.created');
		$result = Hash::remove($result, 'TestWorkflowCommentBehaviorSaveModel.modified');

		//チェック
		$expected = $data;
		$expected = Hash::insert($expected, 'TestWorkflowCommentBehaviorSaveModel.id', '3');
		$expected = Hash::insert($expected, 'WorkflowComment', array(
			'comment' => 'Workflow Comment',
			'plugin_key' => 'test_workflow',
			'block_key' => 'block_key',
			'content_key' => 'new_publish_key'
		));
		$this->assertEqual($expected, $result);

		$count = $this->TestModel->WorkflowComment->find('count', array(
			'recursive' => -1,
			'conditions' => array(
				'content_key' => 'new_publish_key'
			)
		));
		$this->assertEqual(1, $count);
	}

/**
 * save()のテスト(コメントなし)
 *
 * @return void
 */
	public function testSaveWOComment() {
		//テストデータ
		$data = array(
			'TestWorkflowCommentBehaviorSaveModel' => array(
				'key' => 'new_publish_key',
				'status' => '2'
			),
			'Block' => array(
				'key' => 'block_key'
			),
			'WorkflowComment' => array(
				'comment' => ''
			)
		);

		//テスト実施
		$result = $this->TestModel->save($data);
		$this->assertDatetime(Hash::get($result, 'TestWorkflowCommentBehaviorSaveModel.created'));
		$this->assertDatetime(Hash::get($result, 'TestWorkflowCommentBehaviorSaveModel.modified'));
		$result = Hash::remove($result, 'TestWorkflowCommentBehaviorSaveModel.created');
		$result = Hash::remove($result, 'TestWorkflowCommentBehaviorSaveModel.modified');

		//チェック
		$count = $this->TestModel->WorkflowComment->find('count', array(
			'recursive' => -1,
			'conditions' => array(
				'content_key' => 'new_publish_key'
			)
		));
		$this->assertEqual(0, $count);
	}

/**
 * save()のテスト(コメントなし)
 *
 * @return void
 */
	public function testSaveOnExeptionError() {
		//テストデータ
		$this->_mockForReturnFalse('TestModel', 'Workflow.WorkflowComment', 'save');
		$data = array(
			'TestWorkflowCommentBehaviorSaveModel' => array(
				'key' => 'new_publish_key',
				'status' => '2'
			),
			'Block' => array(
				'key' => 'block_key'
			),
			'WorkflowComment' => array(
				'comment' => 'Workflow Comment'
			)
		);

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->save($data);
	}

}
