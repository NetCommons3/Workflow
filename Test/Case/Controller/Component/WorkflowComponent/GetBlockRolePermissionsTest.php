<?php
/**
 * WorkflowComponent::getBlockRolePermissions()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowComponent::getBlockRolePermissions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Controller\Component\WorkflowComponent
 */
class WorkflowComponentGetBlockRolePermissionsTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.roles_room4test',
		'plugin.rooms.roles_rooms_user4test',
		'plugin.rooms.room_role',
		'plugin.rooms.room_role_permission4test',
		'plugin.workflow.block_role_permission4test',
		'plugin.workflow.default_role_permission4test',
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

		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestWorkflowComponent');

		//ログイン
		TestAuthGeneral::login($this);

		//テストアクション実行
		$this->_testGetAction('/test_workflow/test_workflow_component/index',
				array('method' => 'assertNotEmpty'), null, 'view');
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
 * getBlockRolePermissions()のテスト
 *
 * @return void
 */
	public function testGetBlockRolePermissions() {
		//テストデータ
		$permissions = array('content_publishable');
		Current::$current = Hash::insert(Current::$current, 'Block.key', 'block_1');
		Current::$current = Hash::insert(Current::$current, 'Room.id', '1');

		//テスト実行
		$result = $this->controller->Workflow->getBlockRolePermissions($permissions);

		//チェック
		$this->__assertGetBlockRolePermissions($result, $permissions[0]);
	}

/**
 * getBlockRolePermissions()のテスト
 *
 * @return void
 */
	public function testGetBlockRolePermissionsByArgument() {
		//テストデータ
		$permissions = array('content_publishable');

		//テスト実行
		$result = $this->controller->Workflow->getBlockRolePermissions($permissions, '1', 'block_1');

		//チェック
		$this->__assertGetBlockRolePermissions($result, $permissions[0]);
	}

/**
 * getBlockRolePermissions()のテスト
 *
 * @return void
 */
	public function testGetBlockRolePermissionsWORoomAndBlockRolePermission() {
		//テストデータ
		$permissions = array('original_permission');
		Current::$current = Hash::insert(Current::$current, 'Block.key', 'block_1');
		Current::$current = Hash::insert(Current::$current, 'Room.id', '1');

		//テスト実行
		$result = $this->controller->Workflow->getBlockRolePermissions($permissions);

		//チェック
		$this->__assertGetBlockRolePermissions($result, $permissions[0]);
	}

/**
 * getBlockRolePermissions()のテスト
 *
 * @param array $result 結果配列
 * @param array string パーミッション
 * @return void
 */
	private function __assertGetBlockRolePermissions($result, $permission) {
		$this->assertEquals(array('BlockRolePermissions', 'Roles'), array_keys($result));

		$roles = array(
			'room_administrator', 'chief_editor', 'editor', 'general_user', 'visitor'
		);
		$this->assertEquals($roles, array_keys($result['BlockRolePermissions'][$permission]));
		$this->assertEquals($roles, array_keys($result['Roles']));
		if ($permission === 'content_publishable') {
			$this->__assertBlockRolePermission($result, array(
				'id' => '1', 'roles_room_id' => '1', 'role_key' => 'room_administrator', 'value' => true, 'fixed' => true
			), $permission);
			$this->__assertBlockRolePermission($result, array(
				'id' => '2', 'roles_room_id' => '2', 'role_key' => 'chief_editor', 'value' => false, 'fixed' => false
			), $permission);
		} else {
			$this->__assertBlockRolePermission($result, array(
				'id' => null, 'roles_room_id' => '1', 'role_key' => 'room_administrator', 'value' => true, 'fixed' => true
			), $permission);
			$this->__assertBlockRolePermission($result, array(
				'id' => null, 'roles_room_id' => '2', 'role_key' => 'chief_editor', 'value' => true, 'fixed' => false
			), $permission);
		}

		$this->__assertBlockRolePermission($result, array(
			'id' => null, 'roles_room_id' => '3', 'role_key' => 'editor', 'value' => false, 'fixed' => false
		), $permission);
		$this->__assertBlockRolePermission($result, array(
			'id' => null, 'roles_room_id' => '4', 'role_key' => 'general_user', 'value' => false, 'fixed' => true
		), $permission);
		$this->__assertBlockRolePermission($result, array(
			'id' => null, 'roles_room_id' => '5', 'role_key' => 'visitor', 'value' => false, 'fixed' => true
		), $permission);
	}

/**
 * getBlockRolePermissions()のテスト
 *
 * @param array $result 結果配列
 * @param array $excepted 期待値
 * @param array string パーミッション
 * @return void
 */
	private function __assertBlockRolePermission($result, $excepted, $permission) {
		$blockRolePermision = $result['BlockRolePermissions'][$permission];
		$roleKey = $excepted['role_key'];

		$key = 'role_key';
		$this->assertEquals($excepted[$key], Hash::get($blockRolePermision, $roleKey . '.' . $key));

		$key = 'type';
		$this->assertEquals('room_role', Hash::get($blockRolePermision, $roleKey . '.' . $key));

		$key = 'permission';
		$this->assertEquals($permission, Hash::get($blockRolePermision, $roleKey . '.' . $key));

		$key = 'value';
		$this->assertEquals($excepted[$key], Hash::get($blockRolePermision, $roleKey . '.' . $key));

		$key = 'fixed';
		$this->assertEquals($excepted[$key], Hash::get($blockRolePermision, $roleKey . '.' . $key));

		$key = 'roles_room_id';
		$this->assertEquals($excepted[$key], Hash::get($blockRolePermision, $roleKey . '.' . $key));

		$key = 'block_key';
		$this->assertEquals('block_1', Hash::get($blockRolePermision, $roleKey . '.' . $key));

		$key = 'id';
		if (! isset($excepted[$key])) {
			$this->assertArrayNotHasKey($key, Hash::get($blockRolePermision, $roleKey));
		} else {
			$this->assertEquals($excepted[$key], Hash::get($blockRolePermision, $roleKey . '.' . $key));
		}
	}

}
