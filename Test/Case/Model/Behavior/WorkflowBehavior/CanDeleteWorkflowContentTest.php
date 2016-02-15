<?php
/**
 * WorkflowBehavior::canDeleteWorkflowContent()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowBehavior::canDeleteWorkflowContent()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\Behavior\WorkflowBehavior
 */
class WorkflowBehaviorCanDeleteWorkflowContentTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.test_workflow_behavior_model',
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
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorTableModel');
	}

/**
 * canDeleteWorkflowContent()テストのDataProvider
 *
 * ### 戻り値
 *  - editPermission 編集パーミッションの値
 *  - publishPermission 公開パーミッションの値
 *  - assert 期待値
 *  - userId ユーザID
 *  - data コンテンツデータ
 *
 * @return array データ
 */
	public function dataProvider() {
		return array(
			// * 公開権限あり＋編集権限あり
			array('publishPermission' => true, 'editPermission' => true, 'assert' => true, 'userId' => '1',
				'data' => array('TestWorkflowBehaviorModel' => array('key' => 'not_publish_key', 'created_user' => '1'))),
			// * 公開権限なし＋編集権限あり＋一度も公開されていない
			array('publishPermission' => false, 'editPermission' => true, 'assert' => true, 'userId' => '1',
				'data' => array('TestWorkflowBehaviorModel' => array('key' => 'not_publish_key', 'created_user' => '1'))),
			// * 公開権限なし＋編集権限あり＋一度も公開されていない(モデル名なし)
			array('publishPermission' => false, 'editPermission' => true, 'assert' => true, 'userId' => '1',
				'data' => array('key' => 'not_publish_key', 'created_user' => '1')),
			// * 公開権限なし＋編集権限あり＋一度公開されている
			array('publishPermission' => false, 'editPermission' => true, 'assert' => false, 'userId' => '1',
				'data' => array('TestWorkflowBehaviorModel' => array('key' => 'publish_key', 'created_user' => '1'))),
			// * 公開権限なし＋編集権限あり＋keyフィールドデータなし
			array('publishPermission' => false, 'editPermission' => true, 'assert' => false, 'userId' => '1',
				'data' => array('TestWorkflowBehaviorModel' => array('key2' => 'not_publish_key', 'created_user' => '1'))),
			// * 公開権限なし＋編集権限なし
			array('publishPermission' => false, 'editPermission' => false, 'assert' => false, 'userId' => '1',
				'data' => array('TestWorkflowBehaviorModel' => array('key' => 'publish_key', 'created_user' => '2'))),
		);
	}

/**
 * canDeleteWorkflowContent()のテスト
 *
 * @param bool $publishPermission 公開パーミッションの値
 * @param bool $editPermission 編集パーミッションの値
 * @param bool $assert 期待値
 * @param int $userId ユーザID
 * @param array $data コンテンツデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testCanDeleteWorkflowContent($publishPermission, $editPermission, $assert, $userId, $data) {
		//テスト実施
		Current::$current['User']['id'] = $userId;
		Current::$current['Permission']['content_editable']['value'] = $editPermission;
		Current::$current['Permission']['content_publishable']['value'] = $publishPermission;
		$result = $this->TestModel->canDeleteWorkflowContent($data);

		//チェック
		$this->assertEquals($assert, $result);
	}

/**
 * canDeleteWorkflowContent()のテスト(keyフィールドなし)
 *
 * @return void
 */
	public function testCanDeleteWorkflowContentWOKeyField() {
		$this->TestModel = $this->getMockForModel('TestWorkflow.TestWorkflowBehaviorTableModel', array('hasField'));
		$this->_mockForReturnFalse('TestModel', 'TestModel', 'hasField');

		//テスト実施
		Current::$current['User']['id'] = '1';
		Current::$current['Permission']['content_editable']['value'] = true;
		Current::$current['Permission']['content_publishable']['value'] = false;
		$data = array('TestWorkflowBehaviorModel' => array('key' => 'publish_key', 'created_user' => '2'));
		$result = $this->TestModel->canDeleteWorkflowContent($data);

		//チェック
		$this->assertEquals(false, $result);
	}

}
