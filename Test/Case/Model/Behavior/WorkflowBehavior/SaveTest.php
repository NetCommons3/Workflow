<?php
/**
 * WorkflowBehavior::save()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TestWorkflowBehaviorSaveModelFixture', 'Workflow.Test/Fixture');

/**
 * WorkflowBehavior::save()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\Model\Behavior\WorkflowBehavior
 */
class WorkflowBehaviorSaveTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.test_workflow_behavior_save_model',
		'plugin.workflow.test_workflow_behavior_save_w_o_lang_model',
		'plugin.workflow.test_workflow_behavior_save_w_o_status_model',
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
		Current::$current = Hash::insert(Current::$current, 'Permission.content_publishable.value', true);
	}

/**
 * save()のテスト
 *
 * @return void
 */
	public function testSave() {
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorSaveModel');
		$alias = $this->TestModel->alias;

		//事前チェック
		$expected = array($alias => array(
			'id' => '2',
			'language_id' => '2',
			'key' => 'publish_key',
			'status' => '1',
			'is_active' => true,
			'is_latest' => true,
			'created_user' => '1',
			'created' => '2015-01-01 00:00:00',
		));
		$result = $this->TestModel->find('first', array(
			'recursive' => -1,
			'fields' => array_keys($expected[$alias]),
			'conditions' => array('key' => 'publish_key'),
		));
		$this->assertEquals($expected, $result);

		//テストデータ
		$data = array($alias => array(
			'language_id' => '2',
			'key' => 'publish_key',
			'status' => '1',
			'content' => 'Content publish',
		));

		//テスト実施
		$result = $this->TestModel->save($data);
		$result = Hash::remove($result, $alias . '.content');

		//チェック
		$this->assertEquals('3', Hash::get($result, $alias . '.id'));

		$acutal = $this->TestModel->find('first', array(
			'recursive' => -1,
			'fields' => array_keys($expected[$alias]),
			'conditions' => array('id' => '2'),
		));
		$expected[$alias]['is_active'] = false;
		$expected[$alias]['is_latest'] = false;
		$this->assertEquals($expected, $acutal);

		$acutal = $this->TestModel->find('first', array(
			'recursive' => -1,
			'fields' => array_merge(array_keys($expected[$alias]), array('modified')),
			'conditions' => array('id' => '3'),
		));
		$this->assertEquals($result, $acutal);
	}

/**
 * save()のテスト(言語フィールド無し)
 *
 * @return void
 */
	public function testSaveWOLang() {
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorSaveWOLangModel');
		$alias = $this->TestModel->alias;

		//テストデータ
		$data = array($alias => array(
			'key' => 'publish_key',
			'status' => '1',
			'content' => 'Content publish',
		));

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$this->assertEquals('3', Hash::get($result, $alias . '.id'));
	}

/**
 * save()のテスト(statusフィールド無し)
 *
 * @return void
 */
	public function testSaveWOStatus() {
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorSaveWOStatusModel');
		$alias = $this->TestModel->alias;

		//テストデータ
		$data = array($alias => array(
			'language_id' => '2',
			'key' => 'publish_key',
			'content' => 'Content publish',
		));

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$this->assertEquals('3', Hash::get($result, $alias . '.id'));
	}

/**
 * save()のテスト(keyデータ無し)
 *
 * @return void
 */
	public function testSaveWOKey() {
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorSaveModel');
		$alias = $this->TestModel->alias;

		//テストデータ
		$data = array($alias => array(
			'language_id' => '2',
			'key' => '',
			'status' => '1',
			'content' => 'Content publish',
		));

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$this->assertFalse($result);
	}

/**
 * update()のテスト
 *
 * @return void
 */
	public function testUpdate() {
		$this->TestModel = ClassRegistry::init('TestWorkflow.TestWorkflowBehaviorSaveModel');
		$alias = $this->TestModel->alias;

		//テストデータ
		$data = array($alias => array(
			'id' => '2',
			'language_id' => '2',
			'key' => 'publish_key',
			'status' => '1',
			'content' => 'Content publish',
		));

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$this->assertEquals('2', Hash::get($result, $alias . '.id'));

		$acutal = $this->TestModel->find('count', array(
			'recursive' => -1,
			'conditions' => array('id' => '3'),
		));
		$this->assertEquals(0, $acutal);
	}

}
