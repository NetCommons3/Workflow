<?php
/**
 * WorkflowSaveTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowComponent', 'Workflow.Controller/Component');
App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * WorkflowSaveTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\TestSuite
 */
class WorkflowSaveTest extends NetCommonsSaveTest {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '2';
		Current::$current['Permission']['content_editable']['value'] = true;
		Current::$current['Permission']['content_publishable']['value'] = true;
	}

/**
 * Save(公開)のテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return array 登録後のデータ
 */
	public function testSave($data) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$created = !isset($data[$this->$model->alias]['id']);

		//チェック用データ取得
		if (! $created) {
			$before = $this->$model->find('first', array(
				'recursive' => -1,
				'conditions' => array('id' => $data[$this->$model->alias]['id']),
			));
			$saveData = Hash::remove($data, $this->$model->alias . '.id');
		} else {
			$saveData = $data;
			$before[$this->$model->alias] = array();
		}

		//テスト実行
		$result = $this->$model->$method($saveData);
		$this->assertNotEmpty($result);
		$id = $this->$model->getLastInsertID();

		//is_latestのチェック
		if (! $created) {
			$after = $this->$model->find('first', array(
				'recursive' => -1,
				'conditions' => array('id' => $data[$this->$model->alias]['id']),
			));
			$this->assertEquals($after,
				Hash::merge($before, array(
					$this->$model->alias => array('is_latest' => false)
				)
			));
		}

		//更新のチェック
		$actual = $this->_getActual($id, $created);
		$expected = $this->_getExpected($id, $data, $before, $created);
		$this->assertEquals($expected, $actual);

		return $actual;
	}

/**
 * 期待値の取得
 *
 * @param int $id ID
 * @param array $data 登録データ
 * @param array $before 登録前データ
 * @param bool $created 作成かどうか
 * @return array
 */
	protected function _getExpected($id, $data, $before, $created) {
		$model = $this->_modelName;

		$expected = parent::_getExpected($id, $data, $before, $created);
		if ($created) {
			$expected[$this->$model->alias]['key'] = OriginalKeyBehavior::generateKey(
				$this->$model->name, $this->$model->useDbConfig
			);
		}
		$expected[$this->$model->alias]['is_active'] = true;
		$expected[$this->$model->alias]['is_latest'] = true;

		return $expected;
	}

/**
 * Test to call WorkflowBehavior::beforeSave
 *
 * WorkflowBehaviorをモックに置き換えて登録処理を呼び出します。<br>
 * WorkflowBehavior::beforeSaveが1回呼び出されることをテストします。<br>
 * ##### 参考URL
 * http://stackoverflow.com/questions/19833495/how-to-mock-a-cakephp-behavior-for-unit-testing]
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return void
 * @throws CakeException Workflow.Workflowがロードされていないとエラー
 */
	public function testCallWorkflowBehavior($data) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		if (! $this->$model->Behaviors->loaded('Workflow.Workflow')) {
			$error = '"Workflow.Workflow" not loaded in ' . $this->$model->alias . '.';
			throw new CakeException($error);
		};

		ClassRegistry::removeObject('WorkflowBehavior');
		$workflowBehaviorMock = $this->getMock('WorkflowBehavior', ['beforeSave']);
		ClassRegistry::addObject('WorkflowBehavior', $workflowBehaviorMock);
		$this->$model->Behaviors->unload('Workflow');
		$this->$model->Behaviors->load('Workflow', $this->$model->actsAs['Workflow.Workflow']);

		$workflowBehaviorMock
			->expects($this->once())
			->method('beforeSave')
			->will($this->returnValue(true));

		$this->$model->$method($data);
	}

}
