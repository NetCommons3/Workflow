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
		$before = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $data[$this->$model->alias]['id']),
		));

		//テスト実行
		$saveData = Hash::remove($data, $this->$model->alias . '.id');
		parent::testSave($saveData, $model, $method);
		$lastInsertId = $this->$model->getLastInsertID();

		//is_latestのチェック
		$after = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $data[$this->$model->alias]['id']),
		));
		$this->assertEquals($after,
			Hash::merge($before, array(
				$this->$model->alias => array('is_latest' => false)
			)
		));

		//登録データのチェック
		$latest = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $lastInsertId),
		));
		$latest[$this->$model->alias] = Hash::remove($latest[$this->$model->alias], 'modified');
		$latest[$this->$model->alias] = Hash::remove($latest[$this->$model->alias], 'modified_user');

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
