<?php
/**
 * BlockRolePermission4testFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlockRolePermissionFixture', 'Blocks.Test/Fixture');

/**
 * BlockRolePermission4testFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Fixture
 */
class BlockRolePermission4testFixture extends BlockRolePermissionFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'BlockRolePermission';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'block_role_permissions';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//パブリックスペース
		// * ルーム管理者、block_1
		array(
			'id' => '1', 'roles_room_id' => '1', 'block_key' => 'block_1',
			'permission' => 'content_publishable', 'value' => true,
		),
		// * 編集長、block_1
		array(
			'id' => '2', 'roles_room_id' => '2', 'block_key' => 'block_1',
			'permission' => 'content_publishable', 'value' => false,
		),
	);

}
