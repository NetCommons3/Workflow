<?php
/**
 * WorkflowCommentFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * WorkflowCommentFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Fixture
 */
class TestWorkflowBehaviorModelFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false, 'comment' => ''),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ'),
		'is_latest' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '最新コンテンツかどうか 0:最新でない 1:最新'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '作成者 | users.id'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '更新者 | users.id'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'key' => 'not_publish_key',
			'status' => '3',
			'is_active' => false,
			'is_latest' => true,
			'created_user' => '1',
			'created' => '2016-02-17 04:55:38',
			'modified_user' => '1',
			'modified' => '2016-02-17 04:55:38'
		),
		array(
			'id' => '2',
			'key' => 'publish_key',
			'status' => '1',
			'is_active' => true,
			'is_latest' => true,
			'created_user' => '1',
			'created' => '2016-02-17 04:55:38',
			'modified_user' => '1',
			'modified' => '2016-02-17 04:55:38'
		),
	);

}
