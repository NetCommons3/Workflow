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
		Current::$current['Room']['id'] = '1';
		Current::$current['Permission']['content_editable']['value'] = true;
		Current::$current['Permission']['content_publishable']['value'] = true;
	}

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSave($data) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//チェック用データ取得
		if (isset($data[$this->$model->alias]['id'])) {
			$before = $this->$model->find('first', array(
				'recursive' => -1,
				'conditions' => array('id' => $data[$this->$model->alias]['id']),
			));
			$saveData = Hash::remove($data, $this->$model->alias . '.id');
		} else {
			$saveData = $data;
		}

		//テスト実行
		parent::testSave($saveData, $model, $method);
		$lastInsertId = $this->$model->getLastInsertID();

		//登録データ取得
		$latest = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $lastInsertId),
		));

		//is_latestのチェック
		if (isset($before)) {
			$after = $this->$model->find('first', array(
				'recursive' => -1,
				'conditions' => array('id' => $data[$this->$model->alias]['id']),
			));
			$this->assertEquals($after,
				Hash::merge($before, array(
					$this->$model->alias => array('is_latest' => false)
				)
			));
			$latest[$this->$model->alias] = Hash::remove($latest[$this->$model->alias], 'modified');
			$latest[$this->$model->alias] = Hash::remove($latest[$this->$model->alias], 'modified_user');
		} else {
			$latest[$this->$model->alias] = Hash::remove($latest[$this->$model->alias], 'created');
			$latest[$this->$model->alias] = Hash::remove($latest[$this->$model->alias], 'created_user');
			$latest[$this->$model->alias] = Hash::remove($latest[$this->$model->alias], 'modified');
			$latest[$this->$model->alias] = Hash::remove($latest[$this->$model->alias], 'modified_user');

			$data[$this->$model->alias]['key'] = OriginalKeyBehavior::generateKey($this->$model->name, $this->$model->useDbConfig);
			$before[$this->$model->alias] = array();
		}

		$expected[$this->$model->alias] = Hash::merge(
			$before[$this->$model->alias],
			$data[$this->$model->alias],
			array(
				'id' => $lastInsertId,
				'is_active' => true,
				'is_latest' => true
			)
		);
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified');
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified_user');

		$this->assertEquals($latest, $expected);
	}

}
