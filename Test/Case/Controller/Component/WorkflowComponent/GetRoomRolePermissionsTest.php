<?php
/**
 * WorkflowComponent::getRoomRolePermissions()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowComponent::getRoomRolePermissions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Controller\Component\WorkflowComponent
 */
class WorkflowComponentGetRoomRolePermissionsTest extends NetCommonsControllerTestCase {

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

		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestWorkflowComponent');

		//ログイン
		TestAuthGeneral::login($this);

		//テストアクション実行
		$this->_testNcAction('/test_workflow/test_workflow_component/index', array(
			'method' => 'get'
		));
		$pattern = '/' . preg_quote('Controller/Component/TestWorkflowComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * getRoomRolePermissions()のテスト
 *
 * @return void
 */
	public function testGetRoomRolePermissions() {
		//テストデータ生成
		$permissions = array('content_publishable');
		$type = 'room_role';
		$roomId = '1';

		//テスト実行
		$result = $this->controller->Workflow->getRoomRolePermissions($permissions, $type, $roomId);
		$this->__assertGetRoomRolePermissions($result, '1');
	}

/**
 * $roomIdの省略テスト(Current::$current['Room']['id'] = '1')
 *
 * @return void
 */
	public function testGetRoomRolePermissionsWORoomId() {
		//テストデータ生成
		$permissions = array('content_publishable');
		$type = 'room_role';
		Current::$current['Room']['id'] = '1';

		//テスト実行
		$result = $this->controller->Workflow->getRoomRolePermissions($permissions, $type);
		$this->__assertGetRoomRolePermissions($result, '1');
	}

/**
 * $roomIdがNullのテスト(Current::$current['Room']['id']がNull)
 *
 * @return void
 */
	public function testGetRoomRolePermissionsIsNullRoomId() {
		//テストデータ生成
		$permissions = array('content_publishable');
		$type = 'room_role';
		Current::$current['Room']['id'] = null;

		//テスト実行
		$result = $this->controller->Workflow->getRoomRolePermissions($permissions, $type);
		$this->__assertGetRoomRolePermissions($result, null);
	}

/**
 * getRoomRolePermissions()のテスト
 *
 * @param array $result 結果配列
 * @param int|null $roomId ルームID
 * @return void
 */
	private function __assertGetRoomRolePermissions($result, $roomId) {
		$this->assertEquals(
			array('DefaultRolePermission', 'Role', 'RolesRoom', 'RoomRolePermission', 'RoomRole'), array_keys($result)
		);
		$roles = array(
			'room_administrator', 'chief_editor', 'editor', 'general_user', 'visitor'
		);

		$this->assertEquals($roles, array_keys($result['DefaultRolePermission']['content_publishable']));
		$this->assertEquals(
			array('6', '16', '26', '36', '46'), Hash::extract($result, 'DefaultRolePermission.content_publishable.{s}.id')
		);
		$this->assertEquals($roles, Hash::extract($result, 'DefaultRolePermission.content_publishable.{s}.role_key'));

		$this->assertEquals($roles, array_keys($result['Role']));
		$this->assertEquals(
			array('4', '5', '6', '7', '8'), Hash::extract($result, 'Role.{s}.id')
		);
		$this->assertEquals($roles, Hash::extract($result, 'Role.{s}.key'));

		if ($roomId) {
			$this->assertEquals(
				array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'), $result['RolesRoom']
			);

			$this->assertEquals($roles, array_keys($result['RoomRolePermission']['content_publishable']));
			$this->assertEquals(
				array('7', '17', '27', '37', '47'), Hash::extract($result, 'RoomRolePermission.content_publishable.{s}.id')
			);
			$this->assertEquals(
				array('1', '2', '3', '4', '5'), Hash::extract($result, 'RoomRolePermission.content_publishable.{s}.roles_room_id')
			);

			$this->assertEquals($roles, array_keys($result['RoomRole']));
			$this->assertEquals(
				array('1', '2', '3', '4', '5'), Hash::extract($result, 'RoomRole.{s}.id')
			);
			$this->assertEquals($roles, Hash::extract($result, 'RoomRole.{s}.role_key'));
		}
	}

}
