<?php
/**
 * WorkflowBehavior::getWorkflowConditions()のテスト用Fixture(期間付き)
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * WorkflowBehavior::getWorkflowConditions()のテスト用Fixture(期間付き)
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Fixture
 */
class TestWorkflowBehaviorGetWorkflowConditionsWPeriodModelFixture extends CakeTestFixture {

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'test_get_workflow_conditions_w_period_models';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => ''),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6, 'unsigned' => false),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false, 'comment' => ''),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => ''),
		'is_latest' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => ''),
		'public_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'unsigned' => false, 'comment' => ''),
		'publish_start' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => ''),
		'publish_end' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => ''),
		'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => ''),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => ''),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => ''),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => ''),
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
		// * 未承認のコンテンツ
		array(
			'id' => '1',
			'language_id' => '2',
			'key' => 'not_publish_key_1',
			'status' => '3',
			'is_active' => false,
			'is_latest' => true,
			'public_type' => '0',
			'publish_start' => null,
			'publish_end' => null,
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '1',
		),
		// * 未承認のコンテンツ(他人)
		array(
			'id' => '2',
			'language_id' => '2',
			'key' => 'not_publish_key_2',
			'status' => '3',
			'is_active' => false,
			'is_latest' => true,
			'public_type' => '0',
			'publish_start' => null,
			'publish_end' => null,
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '2',
		),
		// * 公開コンテンツ(public_typeが非公開)
		array(
			'id' => '3',
			'language_id' => '2',
			'key' => 'publish_key_1',
			'status' => '1',
			'is_active' => true,
			'is_latest' => true,
			'public_type' => '0',
			'publish_start' => null,
			'publish_end' => null,
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '1',
		),
		// * 公開コンテンツ(public_typeが公開)
		array(
			'id' => '4',
			'language_id' => '2',
			'key' => 'publish_key_2',
			'status' => '1',
			'is_active' => true,
			'is_latest' => true,
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '1',
		),
		// * 公開コンテンツ(public_typeが期間あり、期間内)
		array(
			'id' => '5',
			'language_id' => '2',
			'key' => 'publish_key_3',
			'status' => '1',
			'is_active' => true,
			'is_latest' => true,
			'public_type' => '2',
			'publish_start' => '2014-01-01 00:00:00',
			'publish_end' => '2099-01-01 00:00:00',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '1',
		),
		// * 公開コンテンツ(public_typeが期間あり、すでに終了)
		array(
			'id' => '6',
			'language_id' => '2',
			'key' => 'publish_key_4',
			'status' => '1',
			'is_active' => true,
			'is_latest' => true,
			'public_type' => '2',
			'publish_start' => '2014-01-01 00:00:00',
			'publish_end' => '2015-01-01 00:00:00',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '1',
		),
		// * 公開コンテンツ(public_typeが期間あり、未来)
		array(
			'id' => '7',
			'language_id' => '2',
			'key' => 'publish_key_5',
			'status' => '1',
			'is_active' => true,
			'is_latest' => true,
			'public_type' => '2',
			'publish_start' => '2035-01-01 00:00:00',
			'publish_end' => '2099-01-01 00:00:00',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '1',
		),
		// * 公開コンテンツ(public_typeが期間あり、開始のみ指定)
		array(
			'id' => '8',
			'language_id' => '2',
			'key' => 'publish_key_6',
			'status' => '1',
			'is_active' => true,
			'is_latest' => true,
			'public_type' => '2',
			'publish_start' => '2014-01-01 00:00:00',
			'publish_end' => null,
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '1',
		),
		// * 公開コンテンツ(public_typeが期間あり、終了のみ指定)
		array(
			'id' => '9',
			'language_id' => '2',
			'key' => 'publish_key_7',
			'status' => '1',
			'is_active' => true,
			'is_latest' => true,
			'public_type' => '2',
			'publish_start' => null,
			'publish_end' => '2035-01-01 00:00:00',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '1',
		),
	);

}
