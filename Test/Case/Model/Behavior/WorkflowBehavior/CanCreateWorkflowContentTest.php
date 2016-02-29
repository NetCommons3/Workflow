<?php
/**
 * WorkflowBehavior::canCreateWorkflowContent()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowBehavior::canCreateWorkflowContent()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\Behavior\WorkflowBehavior
 */
class WorkflowBehaviorCanCreateWorkflowContentTest extends NetCommonsModelTestCase {

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
 * canCreateWorkflowContent()テストのDataProvider
 *
 * ### 戻り値
 *  - permission パーミッションの値
 *  - assert 期待値
 *
 * @return array データ
 */
	public function dataProvider() {
		return array(
			array('permission' => true, 'assert' => true),
			array('permission' => false, 'assert' => false)
		);
	}

/**
 * canCreateWorkflowContent()のテスト
 *
 * @param bool $permission パーミッションの値
 * @param bool $assert 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testCanCreateWorkflowContent($permission, $assert) {
		//テスト実施
		Current::$current['Permission']['content_creatable']['value'] = $permission;
		$result = $this->TestModel->canCreateWorkflowContent();

		//チェック
		$this->assertEquals($assert, $result);
	}

}
