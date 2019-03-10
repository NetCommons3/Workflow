<?php
/**
 * WorkflowBehavior::getWorkflowConditions()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowBehavior::getWorkflowConditions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\Behavior\WorkflowBehavior
 */
class WorkflowBehaviorGetWorkflowConditionsTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.test_workflow_behavior_get_workflow_conditions_model',
		'plugin.workflow.test_workflow_behavior_get_workflow_conditions_w_period_model',
		'plugin.workflow.test_workflow_behavior_get_workflow_conditions_w_o_lang_model',
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
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorGetWorkflowConditionsModel');
		$this->TestWPeriodModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorGetWorkflowConditionsWPeriodModel');
		$this->TestWOLangModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorGetWorkflowConditionsWOLangModel');
	}

/**
 * getWorkflowConditions()のテスト
 * [public_typeなし、作成権限なし]
 *
 * @return void
 */
	public function testWOContentCreateable() {
		//テストデータ
		$conditions = array();

		//テスト実施
		$conditions = $this->TestModel->getWorkflowConditions($conditions);
		$expected = array(
			array(
				'OR' => array(
					$this->TestModel->alias . '.language_id' => '2',
					$this->TestModel->alias . '.is_translation' => false,
				),
			),
			array(
				'OR' => array(
					array($this->TestModel->alias . '.is_active' => true),
					array()
				),
			),
		);
		$this->assertEquals($expected, $conditions);

		$result = $this->TestModel->find('list', array(
			'fields' => array('id', 'key'),
			'conditions' => $conditions,
			'order' => array('id' => 'asc')
		));
		$expected = array(
			'3' => 'publish_key',
		);
		$this->assertEquals($expected, $result);
	}

/**
 * getWorkflowConditions()のテスト
 * [public_typeあり、作成権限なし]
 *
 * @return void
 */
	public function testPeriodWOContentCreateable() {
		//テストデータ
		$conditions = array();

		//テスト実施
		$conditions = $this->TestWPeriodModel->getWorkflowConditions($conditions);
		$result = $this->TestWPeriodModel->find('list', array(
			'fields' => array('id', 'key'),
			'conditions' => $conditions,
			'order' => array('id' => 'asc')
		));
		$expected = array(
			'4' => 'publish_key_2',
			'5' => 'publish_key_3',
			'8' => 'publish_key_6',
			'9' => 'publish_key_7',
		);
		$this->assertEquals($expected, $result);
	}

/**
 * getWorkflowConditions()のテスト
 * [public_typeなし、作成権限なし]
 *
 * @return void
 */
	public function testWOLangWOContentCreateable() {
		//テストデータ
		$conditions = array();

		//テスト実施
		$conditions = $this->TestWOLangModel->getWorkflowConditions($conditions);
		$expected = array(
			array(),
			array(
				'OR' => array(
					array($this->TestWOLangModel->alias . '.is_active' => true),
					array()
				),
			),
		);
		$this->assertEquals($expected, $conditions);

		$result = $this->TestWOLangModel->find('list', array(
			'fields' => array('id', 'key'),
			'conditions' => $conditions,
			'order' => array('id' => 'asc')
		));
		$expected = array(
			'3' => 'publish_key',
		);
		$this->assertEquals($expected, $result);
	}

/**
 * getWorkflowConditions()のテスト
 * [public_typeなし、作成権限あり]
 *
 * @return void
 */
	public function testWithContentCreatable() {
		//テストデータ
		$conditions = array();
		Current::write('Room.id', '2');
		Current::writePermission('2', 'content_creatable', true);
		Current::write('User.id', '2');

		//テスト実施
		$conditions = $this->TestModel->getWorkflowConditions($conditions);
		$result = $this->TestModel->find('list', array(
			'fields' => array('id', 'key'),
			'conditions' => $conditions,
			'order' => array('id' => 'asc')
		));
		$expected = array(
			'2' => 'not_publish_key_2',
			'3' => 'publish_key',
		);
		$this->assertEquals($expected, $result);
	}

/**
 * getWorkflowConditions()のテスト
 * [public_typeあり、作成権限あり]
 *
 * @return void
 */
	public function testPeriodWithContentCreatable() {
		//テストデータ
		$conditions = array();
		Current::write('Room.id', '2');
		Current::writePermission('2', 'content_creatable', true);
		Current::write('User.id', '2');

		//テスト実施
		$conditions = $this->TestWPeriodModel->getWorkflowConditions($conditions);
		$result = $this->TestWPeriodModel->find('list', array(
			'fields' => array('id', 'key'),
			'conditions' => $conditions,
			'order' => array('id' => 'asc')
		));

		$expected = array(
			'2' => 'not_publish_key_2',
			'4' => 'publish_key_2',
			'5' => 'publish_key_3',
			'8' => 'publish_key_6',
			'9' => 'publish_key_7',
		);
		$this->assertEquals($expected, $result);
	}

/**
 * getWorkflowConditions()のテスト
 * [public_typeなし、編集権限あり]
 *
 * @return void
 */
	public function testWithContentEditable() {
		//テストデータ
		$conditions = array();
		Current::write('Room.id', '2');
		Current::writePermission('2', 'content_editable', true);
		Current::write('User.id', '2');

		//テスト実施
		$conditions = $this->TestModel->getWorkflowConditions($conditions);
		$result = $this->TestModel->find('list', array(
			'fields' => array('id', 'key'),
			'conditions' => $conditions,
			'order' => array('id' => 'asc')
		));
		$expected = array(
			'1' => 'not_publish_key_1',
			'2' => 'not_publish_key_2',
			'3' => 'publish_key',
		);
		$this->assertEquals($expected, $result);
	}

/**
 * getWorkflowConditions()のテスト
 * [public_typeあり、編集権限あり]
 *
 * @return void
 */
	public function testPeriodWithContentEditable() {
		//テストデータ
		$conditions = array();
		Current::write('Room.id', '2');
		Current::writePermission('2', 'content_editable', true);
		Current::write('User.id', '2');

		//テスト実施
		$conditions = $this->TestWPeriodModel->getWorkflowConditions($conditions);
		$result = $this->TestWPeriodModel->find('list', array(
			'fields' => array('id', 'key'),
			'conditions' => $conditions,
			'order' => array('id' => 'asc')
		));
		$expected = array(
			'1' => 'not_publish_key_1',
			'2' => 'not_publish_key_2',
			'3' => 'publish_key_1',
			'4' => 'publish_key_2',
			'5' => 'publish_key_3',
			'6' => 'publish_key_4',
			'7' => 'publish_key_5',
			'8' => 'publish_key_6',
			'9' => 'publish_key_7',
		);
		$this->assertEquals($expected, $result);
	}

}
