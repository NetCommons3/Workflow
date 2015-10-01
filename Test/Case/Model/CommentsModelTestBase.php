<?php
/**
 * Comment Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('Comment', 'Workflow.Model');
App::uses('YACakeTestCase', 'NetCommons.TestSuite');

/**
 * Comment Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model
 */
class CommentsModelTestBase extends YACakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.comment',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Comment = ClassRegistry::init('Workflow.Comment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Comment);

		parent::tearDown();
	}

/**
 * _assertArray method
 *
 * @param array $expected expected data
 * @param array $result result data
 * @return void
 */
	//protected function _assertArray($expected, $result) {
	//	$result = Hash::remove($result, 'created');
	//	$result = Hash::remove($result, 'created_user');
	//	$result = Hash::remove($result, 'modified');
	//	$result = Hash::remove($result, 'modified_user');
	//	$result = Hash::remove($result, '{s}.created');
	//	$result = Hash::remove($result, '{s}.created_user');
	//	$result = Hash::remove($result, '{s}.modified');
	//	$result = Hash::remove($result, '{s}.modified_user');
	//	$result = Hash::remove($result, '{n}.{s}.created');
	//	$result = Hash::remove($result, '{n}.{s}.created_user');
	//	$result = Hash::remove($result, '{n}.{s}.modified');
	//	$result = Hash::remove($result, '{n}.{s}.modified_user');
	//	$result = Hash::remove($result, 'TrackableCreator');
	//	$result = Hash::remove($result, 'TrackableUpdater');
	//	$result = Hash::remove($result, '{n}.TrackableCreator');
	//	$result = Hash::remove($result, '{n}.TrackableUpdater');
	//
	//	$this->assertEquals($expected, $result);
	//}

}
