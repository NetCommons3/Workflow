<?php
/**
 * Workflow Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * Workflow Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Controller\Component
 */
class WorkflowComponent extends Component {

/**
 * status published
 *
 * @var string
 */
	const STATUS_PUBLISHED = '1';

/**
 * status approved
 * 後で削除
 *
 * @var string
 */
	const STATUS_APPROVED = '2';

/**
 * status approved
 *
 * @var string
 */
	const STATUS_APPROVAL_WAITING = '2';

/**
 * in draft status
 *
 * @var string
 */
	const STATUS_IN_DRAFT = '3';

/**
 * status disaproved
 *
 * @var string
 */
	const STATUS_DISAPPROVED = '4';

/**
 * RoomRoles Data
 *
 * @var
 */
	protected $_roomRoles = null;

/**
 * Roles data
 * @var
 */
	protected $_roles = null;

/**
 * DefaultPermission data
 * @var
 */
	protected $_defaultPermissions = null;

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Controller with components to initialize
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::initialize
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}

/**
 * 固定的データが準備できているかチェックする
 *
 * @param array $permissions default permissionの情報抽出のpermissions
 * @param int $type default permissionの情報抽出のtype
 * @return bool
 */
	private function __isNotPrepareInitialData($permissions, $type) {
		static $mementoPermissions = array();
		static $mementoType = null;
		$isDiff = false;
		if (implode(',', $mementoPermissions) != implode(',', $permissions) || $mementoType != $type) {
			$isDiff = true;
			$mementoPermissions = $permissions;
			$mementoType = $type;
		}
		return is_null($this->_roomRoles) ||
			is_null($this->_roles) ||
			is_null($this->_defaultPermissions) || $isDiff;
	}

/**
 * 固定的なデータを確保する
 *
 * @param array $permissions default permissionの情報抽出のpermissions
 * @param int $type default permissionの情報抽出のtype
 * @return bool
 */
	private function __prepareInitialData($permissions, $type) {
		if ($this->__isNotPrepareInitialData($permissions, $type)) {
			// 固定的なデータなので最初に保持しておくようにする
			$roomRoles = $this->RoomRole->find('all', array(
				'recursive' => -1,
			));
			$this->_roomRoles = Hash::combine($roomRoles, '{n}.RoomRole.role_key', '{n}.RoomRole');
			$roles = $this->Role->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'Role.type' => Role::ROLE_TYPE_ROOM,
					'Role.language_id' => Current::read('Language.id'),
				),
			));
			$this->_roles = Hash::combine($roles, '{n}.Role.key', '{n}.Role');

			$this->_defaultPermissions = $this->DefaultRolePermission->find('all', array(
				'recursive' => -1,
				'fields' => array('DefaultRolePermission.*', 'DefaultRolePermission.value AS default'),
				'conditions' => array(
					'DefaultRolePermission.type' => $type,
					'DefaultRolePermission.permission' => $permissions,
				),
			));
		}
	}

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 */
	public function startup(Controller $controller) {
		if (! in_array('Users.DisplayUser', $controller->helpers, true)) {
			$controller->helpers[] = 'Users.DisplayUser';
		}
	}

/**
 * Parse content status from request
 *
 * @return mixed status on success, false on error
 * @throws BadRequestException
 */
	public function parseStatus() {
		$matches = preg_grep('/^save_\d/', array_keys($this->controller->data));
		if ($matches) {
			list(, $status) = explode('_', array_shift($matches));
			return $status;
		} else {
			return $this->controller->setAction('throwBadRequest');
		}
	}

/**
 * Function to get the data of BlockRolePermmissions.
 *    e.g.) BlockRolePermmissions controller
 *
 * @param array $permissions パーミッションリスト
 * @param int $roomId ルームID
 * @param string $blockKey ブロックKey
 * @return array Role and Permissions data
 *   - The `Role` merged of Role and RoomRole
 *   - The `Permission` sets in priority of BlockRolePermission and RoomRolePermission and DefaultRolePermission.
 */
	public function getBlockRolePermissions($permissions, $roomId = null, $blockKey = null) {
		//modelのロード
		$models = array(
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
			'DefaultRolePermission' => 'Roles.DefaultRolePermission',
			'Role' => 'Roles.Role',
			'RolesRoom' => 'Rooms.RolesRoom',
			'RoomRole' => 'Rooms.RoomRole',
			'RoomRolePermission' => 'Rooms.RoomRolePermission',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class, true);
		}

		if (! isset($blockKey)) {
			$blockKey = Current::read('Block.key');
		}

		//RoomRolePermissions取得
		$results = $this->getRoomRolePermissions(
			$permissions, DefaultRolePermission::TYPE_ROOM_ROLE, $roomId
		);
		$defaultPermissions = Hash::remove($results['DefaultRolePermission'], '{s}.{s}.id');
		$roles = $results['Role'];
		$rolesRooms = $results['RolesRoom'];
		$roomRolePermissions = Hash::remove($results['RoomRolePermission'], '{s}.{s}.id');
		$roomRoles = $results['RoomRole'];

		//BlockRolePermission取得
		$blockPermissions = $this->BlockRolePermission->find('all', array(
			'recursive' => 0,
			'conditions' => array(
				'BlockRolePermission.roles_room_id' => array_values($rolesRooms),
				'BlockRolePermission.block_key' => $blockKey,
				'BlockRolePermission.permission' => $permissions,
			),
		));
		$blockPermissions = Hash::combine(
			$blockPermissions,
			'{n}.RolesRoom.role_key',
			'{n}.BlockRolePermission',
			'{n}.BlockRolePermission.permission'
		);

		//戻り値の設定
		$results = array(
			'BlockRolePermissions' => Hash::merge(
				$defaultPermissions, $roomRolePermissions, $blockPermissions
			),
			'Roles' => Hash::merge($roomRoles, $roles)
		);

		//block_keyのセット
		$results['BlockRolePermissions'] = Hash::insert(
			$results['BlockRolePermissions'], '{s}.{s}.block_key', $blockKey
		);
		foreach ($rolesRooms as $roleKey => $rolesRoomId) {
			$results['BlockRolePermissions'] = Hash::insert(
				$results['BlockRolePermissions'],
				'{s}.' . $roleKey . '.roles_room_id',
				$rolesRoomId
			);
		}
		return $results;
	}

/**
 * Function to get the data of RoomRolePermmissions.
 *    e.g.) RoomRolePermmissions controller
 *
 * @param array $permissions パーミッションリスト
 * @param string $type タイプ(DefaultRolePermissions.type)
 * @param int $roomId ルームID
 * @return array Role and Permissions and Rooms data
 *   - The `DefaultPermissions` data.
 *   - The `Roles` data.
 *   - The `RolesRooms` data.
 *   - The `RoomRolePermissions` data.
 *   - The `RoomRoles` data.
 */
	public function getRoomRolePermissions($permissions, $type, $roomId = null) {
		//戻り値の設定
		$results = array(
			'DefaultRolePermission' => null,
			'Role' => null,
			'RolesRoom' => null,
			'RoomRolePermission' => null,
			'RoomRole' => null,
		);

		//modelのロード
		$models = array(
			'DefaultRolePermission' => 'Roles.DefaultRolePermission',
			'Role' => 'Roles.Role',
			'RolesRoom' => 'Rooms.RolesRoom',
			'RoomRole' => 'Rooms.RoomRole',
			'RoomRolePermission' => 'Rooms.RoomRolePermission',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class, true);
		}

		if (! $roomId) {
			$roomId = Current::read('Room.id');
		}

		$this->__prepareInitialData($permissions, $type);

		//RoomRole取得
		$results['RoomRole'] = $this->_roomRoles;

		//Role取得
		$results['Role'] = $this->_roles;

		//DefaultRolePermission取得
		$results['DefaultRolePermission'] = Hash::combine(
			$this->_defaultPermissions,
			'{n}.DefaultRolePermission.role_key',
			'{n}.DefaultRolePermission',
			'{n}.DefaultRolePermission.permission'
		);

		if (! isset($roomId)) {
			return $results;
		}

		$roleKeys = Hash::combine($this->_defaultPermissions, '{n}.DefaultRolePermission.role_key');

		//RolesRoomのIDリストを取得
		$results['RolesRoom'] = $this->RolesRoom->find('list', array(
			'recursive' => -1,
			'fields' => array('role_key', 'id'),
			'conditions' => array(
				'RolesRoom.room_id' => $roomId,
				'RolesRoom.role_key' => array_keys($roleKeys),
			),
		));

		//RoomRolePermission取得
		$roomRolePermissions = $this->RoomRolePermission->find('all', array(
			'recursive' => 0,
			'conditions' => array(
				'RoomRolePermission.roles_room_id' => $results['RolesRoom'],
				'RoomRolePermission.permission' => $permissions,
			),
		));
		$results['RoomRolePermission'] = Hash::combine(
			$roomRolePermissions,
			'{n}.RolesRoom.role_key',
			'{n}.RoomRolePermission',
			'{n}.RoomRolePermission.permission'
		);
		//$results['RoomRolePermission'] = Hash::remove($roomRolePermissions, '{s}.{s}.id');

		//戻り値の設定
		return $results;
	}

}
