<?php
/**
 * アクセス権限(Permission)テスト用Fixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('DefaultRolePermissionFixture', 'Roles.Test/Fixture');

/**
 * アクセス権限(Permission)テスト用Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class DefaultRolePermission4testFixture extends DefaultRolePermissionFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'DefaultRolePermission';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'default_role_permissions';

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		$this->records = array_merge($this->records, array(
			//HTMLタグの書き込み制限
			array('role_key' => 'room_administrator', 'type' => 'room_role', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'room_role', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'room_role', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'room_role', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'room_role', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '1', ),
			//投稿をメール通知する権限
			array('role_key' => 'room_administrator', 'type' => 'room_role', 'permission' => 'mail_content_receivable', 'value' => '1', 'fixed' => '1', ),
			array('role_key' => 'chief_editor', 'type' => 'room_role', 'permission' => 'mail_content_receivable', 'value' => '1', 'fixed' => '1', ),
			array('role_key' => 'editor', 'type' => 'room_role', 'permission' => 'mail_content_receivable', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'room_role', 'permission' => 'mail_content_receivable', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'room_role', 'permission' => 'mail_content_receivable', 'value' => '0', 'fixed' => '0', ),
			//回答をメール通知する権限
			array('role_key' => 'room_administrator', 'type' => 'room_role', 'permission' => 'mail_answer_receivable', 'value' => '1', 'fixed' => '1', ),
			array('role_key' => 'chief_editor', 'type' => 'room_role', 'permission' => 'mail_answer_receivable', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'room_role', 'permission' => 'mail_answer_receivable', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'room_role', 'permission' => 'mail_answer_receivable', 'value' => '0', 'fixed' => '1', ),
			array('role_key' => 'visitor', 'type' => 'room_role', 'permission' => 'mail_answer_receivable', 'value' => '0', 'fixed' => '1', ),
			//独自パーミッション
			array('role_key' => 'room_administrator', 'type' => 'room_role', 'permission' => 'original_permission', 'value' => '1', 'fixed' => '1', ),
			array('role_key' => 'chief_editor', 'type' => 'room_role', 'permission' => 'original_permission', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'room_role', 'permission' => 'original_permission', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'room_role', 'permission' => 'original_permission', 'value' => '0', 'fixed' => '1', ),
			array('role_key' => 'visitor', 'type' => 'room_role', 'permission' => 'original_permission', 'value' => '0', 'fixed' => '1', ),
		));

		parent::init();
	}

}
