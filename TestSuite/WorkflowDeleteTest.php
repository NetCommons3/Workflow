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
App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowSaveTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\TestSuite
 */
class WorkflowDeleteTest extends NetCommonsModelTestCase {

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
 * Deleteのテスト
 *
 * @param array $data 削除データ
 * @param string $model モデル名
 * @param string $method メソッド
 * @dataProvider dataProviderDelete
 * @return void
 */
	public function testDelete($data, $model, $method) {
		//テスト実行前のチェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('key' => $data[$this->$model->alias]['key']),
		));
		$this->assertNotEquals(0, $count);

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertTrue($result);

		//チェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('key' => $data[$this->$model->alias]['key']),
		));
		$this->assertEquals(0, $count);
	}

/**
 * DeleteのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $model モデル名
 * @param string $method メソッド
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderDeleteOnExceptionError
 * @return void
 */
	public function testDeleteOnExceptionError($data, $model, $method, $mockModel, $mockMethod) {
		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->setExpectedException('InternalErrorException');
		$this->$model->$method($data);
	}

}
