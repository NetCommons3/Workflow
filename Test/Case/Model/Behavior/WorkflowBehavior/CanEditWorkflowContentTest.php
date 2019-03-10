<?php
/**
 * WorkflowBehavior::canEditWorkflowContent()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowBehavior::canEditWorkflowContent()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\Behavior\WorkflowBehavior
 */
class WorkflowBehaviorCanEditWorkflowContentTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

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
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorModel');
	}

/**
 * canEditWorkflowContent()テストのDataProvider
 *
 * ### 戻り値
 *  - permission パーミッションの値
 *  - assert 期待値
 *  - userId ユーザID
 *  - data コンテンツデータ
 *
 * @return array データ
 */
	public function dataProvider() {
		return array(
			// * 編集権限あり
			array('permission' => true, 'assert' => true, 'userId' => '1',
				'data' => array('TestWorkflowBehaviorModel' => array('created_user' => '1'))),
			// * 編集権限なし＋自分自身
			array('permission' => false, 'assert' => true, 'userId' => '1',
				'data' => array('TestWorkflowBehaviorModel' => array('created_user' => '1'))),
			// * 編集権限なし＋自分自身(モデル名なし)
			array('permission' => false, 'assert' => true, 'userId' => '1',
				'data' => array('created_user' => '1')),
			// * 編集権限なし＋created_userフィールドなし
			array('permission' => false, 'assert' => false, 'userId' => '1',
				'data' => array('TestWorkflowBehaviorModel' => array('modified_user' => '1'))),
			// * 編集権限なし＋他人
			array('permission' => false, 'assert' => false, 'userId' => '1',
				'data' => array('TestWorkflowBehaviorModel' => array('created_user' => '2'))),
		);
	}

/**
 * canEditWorkflowContent()のテスト
 *
 * @param bool $permission パーミッションの値
 * @param bool $assert 期待値
 * @param int $userId ユーザID
 * @param array $data コンテンツデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testCanEditWorkflowContent($permission, $assert, $userId, $data) {
		//テスト実施
		Current::$current['User']['id'] = $userId;
		Current::write('Room.id', '2');
		Current::writePermission('2', 'content_editable', $permission);
		$result = $this->TestModel->canEditWorkflowContent($data);

		//チェック
		$this->assertEquals($assert, $result);
	}

}
