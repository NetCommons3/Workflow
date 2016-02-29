<?php
/**
 * WorkflowCommentBehavior::validates()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TestWorkflowCommentBehaviorValidatesModelFixture', 'Workflow.Test/Fixture');

/**
 * WorkflowCommentBehavior::validates()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\Behavior\WorkflowCommentBehavior
 */
class WorkflowCommentBehaviorValidatesTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.workflow_comment',
		'plugin.workflow.test_workflow_comment_behavior_validates_model',
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
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowCommentBehaviorValidatesModel');
	}

/**
 * validates()のテスト
 *
 * @return void
 */
	public function testValidates() {
		//テストデータ
		$data = array(
			'WorkflowComment' => array(
				'comment' => 'aaa',
			),
			'TestWorkflowCommentBehaviorValidatesModel' => (new TestWorkflowCommentBehaviorValidatesModelFixture())->records[0],
		);

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();

		//チェック
		$this->assertInternalType('array', $this->TestModel->validationErrors);
		$this->assertTrue($result);
	}

/**
 * statusフィールドなしのテスト
 *
 * @return void
 */
	public function testWithoutStatusField() {
		//テストデータ
		$data = array(
			'WorkflowComment' => array(
				'comment' => 'aaa',
			),
			'TestWorkflowCommentBehaviorValidatesModel' => (new TestWorkflowCommentBehaviorValidatesModelFixture())->records[0],
		);
		$data = Hash::remove($data, 'TestWorkflowCommentBehaviorValidatesModel.status');
		$this->assertArrayNotHasKey('status', $data['TestWorkflowCommentBehaviorValidatesModel']);

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();

		//チェック
		$this->assertInternalType('array', $this->TestModel->validationErrors);
		$this->assertTrue($result);
		$this->assertArrayHasKey('status', $this->TestModel->data['TestWorkflowCommentBehaviorValidatesModel']);
		$this->assertNull($this->TestModel->data['TestWorkflowCommentBehaviorValidatesModel']['status']);
	}

/**
 * WorkflowCommentなしのテスト
 *
 * @return void
 */
	public function testWithoutWorkflowComment() {
		//テストデータ
		$data = array(
			'TestWorkflowCommentBehaviorValidatesModel' => (new TestWorkflowCommentBehaviorValidatesModelFixture())->records[0],
		);

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();

		//チェック
		$this->assertInternalType('array', $this->TestModel->validationErrors);
		$this->assertTrue($result);
	}

/**
 * WorkflowCommentなしのテスト
 *
 * @return void
 */
	public function testEmptyCommentWithDisapproved() {
		//テストデータ
		$data = array(
			'WorkflowComment' => array(
				'comment' => '',
			),
			'TestWorkflowCommentBehaviorValidatesModel' => (new TestWorkflowCommentBehaviorValidatesModelFixture())->records[0],
		);
		$data['TestWorkflowCommentBehaviorValidatesModel']['status'] = '4';

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();

		//チェック
		$this->assertTextContains(
			__d('net_commons', 'If it is not approved, comment is a required input.'),
			Hash::get($this->TestModel->WorkflowComment->validationErrors, 'comment.0')
		);
		$this->assertFalse($result);
	}

}
