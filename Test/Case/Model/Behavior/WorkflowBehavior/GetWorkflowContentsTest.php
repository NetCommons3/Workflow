<?php
/**
 * WorkflowBehavior::getWorkflowContents()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowBehavior::getWorkflowContents()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\Behavior\WorkflowBehavior
 */
class WorkflowBehaviorGetWorkflowContentsTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.test_workflow_behavior_model',
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
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorTableModel');
	}

/**
 * getWorkflowContents()テストのDataProvider
 *
 * ### 戻り値
 *  - type Type of find operation (all / first / count / neighbors / list / threaded)
 *  - query Option fields (conditions / fields / joins / limit / offset / order / page / group / callbacks)
 *
 * @return array データ
 */
	public function dataProvider() {
		$result = array();

		$result[0]['type'] = 'list';
		$result[0]['query'] = array(
			'fields' => array('id', 'key')
		);

		return $result;
	}

/**
 * getWorkflowContents()のテスト
 *
 * @param string $type Type of find operation (all / first / count / neighbors / list / threaded)
 * @param array $query Option fields (conditions / fields / joins / limit / offset / order / page / group / callbacks)
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetWorkflowContents($type, $query) {
		//テスト実施
		$result = $this->TestModel->getWorkflowContents($type, $query);

		//チェック
		$expected = array('2' => 'publish_key');
		$this->assertEquals($expected, $result);
	}

}
