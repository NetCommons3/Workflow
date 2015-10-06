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
class WorkflowSaveTest extends NetCommonsModelTestCase {

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
 * @param string $model モデル名
 * @param string $method メソッド
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSave($data, $model, $method) {
		//チェック用データ取得
		$before = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $data[$this->$model->alias]['id']),
		));

		//テスト実行
		$saveData = Hash::remove($data, $this->$model->alias . '.id');
		$result = $this->$model->$method($saveData);
		$this->assertNotEmpty($result);
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

/**
 * SaveのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $model モデル名
 * @param string $method メソッド
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnExceptionError
 * @return void
 */
	public function testSaveOnExceptionError($data, $model, $method, $mockModel, $mockMethod) {
		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->setExpectedException('InternalErrorException');
		$this->$model->$method($data);
	}

/**
 * SaveのValidationErrorテスト
 *
 * @param array $data 登録データ
 * @param string $model モデル名
 * @param string $method メソッド
 * @dataProvider dataProviderSaveOnValidationError
 * @return void
 */
	public function testSaveOnValidationError($data, $model, $method, $mockModel) {
		$this->_mockForReturnFalse($model, $mockModel, 'validates');
		$result = $this->$model->$method($data);
		$this->assertFalse($result);
	}

/**
 * Validatesのテスト
 *
 * @param array $data 登録データ
 * @param string $model モデル名
 * @param string $field フィールド名
 * @param string $value セットする値
 * @param string $message エラーメッセージ
 * @param array $overwrite 上書きするデータ
 * @dataProvider dataProviderValidationError
 * @return void
 */
	public function testValidationError($data, $model, $field, $value, $message, $overwrite = array()) {
		if (is_null($value)) {
			unset($data[$model][$field]);
		} else {
			$data[$model][$field] = $value;
		}
		$data = Hash::merge($data, $overwrite);

		//validate処理実行
		$this->$model->set($data);
		$result = $this->$model->validates();
		$this->assertFalse($result);

		$this->assertEquals($this->$model->validationErrors[$field][0], $message);
	}

}
