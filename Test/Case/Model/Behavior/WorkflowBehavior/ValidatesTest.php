<?php
/**
 * WorkflowBehavior::validates()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TestWorkflowBehaviorValidatesModelFixture', 'Workflow.Test/Fixture');

/**
 * WorkflowBehavior::validates()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\Behavior\WorkflowBehavior
 */
class WorkflowBehaviorValidatesTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.test_workflow_behavior_validates_model',
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
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorValidatesModel');
	}

/**
 * validates()のテスト
 *
 * @return void
 */
	public function testValidates() {
		//テストデータ
		$data = array(
			'TestWorkflowBehaviorValidatesModel' => (new TestWorkflowBehaviorValidatesModelFixture())->records[0],
		);

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();

		//チェック
		$this->assertInternalType('array', $this->TestModel->validationErrors);
		$this->assertTrue($result);
	}

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - value セットする値
 *  - publishable 公開権限の有無
 *  - error エラーの有無
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			// * 数値以外⇒エラー
			array('value' => 'a', 'publishable' => true, 'error' => true),
			// * 公開＋公開権限あり⇒エラーなし
			array('value' => '1', 'publishable' => true, 'error' => false),
			// * 公開＋公開権限なし⇒エラー
			array('value' => '1', 'publishable' => false, 'error' => true),
			// * 申請＋公開権限あり⇒エラー
			array('value' => '2', 'publishable' => true, 'error' => true),
			// * 申請＋公開権限なし⇒エラーなし
			array('value' => '2', 'publishable' => false, 'error' => false),
			// * 一時保存＋公開権限あり⇒エラーなし
			array('value' => '3', 'publishable' => true, 'error' => false),
			// * 一時保存＋公開権限なし⇒エラーなし
			array('value' => '3', 'publishable' => false, 'error' => false),
			// * 差し戻し＋公開権限あり⇒エラーなし
			array('value' => '4', 'publishable' => true, 'error' => false),
			// * 差し戻し＋公開権限なし⇒エラー
			array('value' => '4', 'publishable' => false, 'error' => true),
			// * 不正＋公開権限あり⇒エラー
			array('value' => '99', 'publishable' => true, 'error' => true),
			// * 不正＋公開権限なし⇒エラー
			array('value' => '99', 'publishable' => false, 'error' => true),
		);
	}

/**
 * Validatesのテスト
 *
 * @param string $value セットする値
 * @param bool $publishable 公開権限の有無
 * @param bool $error エラーの有無
 * @dataProvider dataProvider
 * @return void
 */
	public function testValidationError($value, $publishable, $error) {
		$model = 'TestWorkflowBehaviorValidatesModel';
		$field = 'status';
		$message = __d('net_commons', 'Invalid request.');

		if ($publishable) {
			Current::write('Room.id', '2');
			Current::writePermission('2', 'content_publishable', true);
		}
		$data = array($model => (new TestWorkflowBehaviorValidatesModelFixture())->records[0]);
		$data[$model][$field] = $value;

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();

		//チェック
		if ($error) {
			$this->assertFalse($result);
			$this->assertEquals($this->TestModel->validationErrors[$field][0], $message);
		} else {
			$this->assertInternalType('array', $this->TestModel->validationErrors);
			$this->assertTrue($result);
		}
	}

/**
 * idがない(新規を想定)のテスト
 *
 * @return void
 */
	public function testValidationErrorWithCreated() {
		//テストデータ
		$model = 'TestWorkflowBehaviorValidatesModel';
		$field = 'status';
		$message = __d('net_commons', 'Invalid request.');

		$data = array($model => (new TestWorkflowBehaviorValidatesModelFixture())->records[0]);
		$data = Hash::remove($data, 'TestWorkflowBehaviorValidatesModel.id');
		$data = Hash::remove($data, 'TestWorkflowBehaviorValidatesModel.status');
		$this->assertArrayNotHasKey('id', $data['TestWorkflowBehaviorValidatesModel']);
		$this->assertArrayNotHasKey('status', $data['TestWorkflowBehaviorValidatesModel']);

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();

		//チェック
		$this->assertFalse($result);
		$this->assertEquals($this->TestModel->validationErrors[$field][0], $message);
	}

/**
 * statusフィールドなしのテスト
 *
 * @return void
 */
	public function testWithoutStatusField() {
		$model = 'TestWorkflowBehaviorValidatesModel';
		$this->TestModel = $this->getMockForModel('TestWorkflow.TestWorkflowBehaviorValidatesModel', array('hasField'));
		$this->_mockForReturnFalse('TestModel', 'TestModel', 'hasField');

		//テストデータ
		$data = array(
			$model => (new TestWorkflowBehaviorValidatesModelFixture())->records[0],
		);

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();

		//チェック
		$this->assertInternalType('array', $this->TestModel->validationErrors);
		$this->assertTrue($result);
	}

}
