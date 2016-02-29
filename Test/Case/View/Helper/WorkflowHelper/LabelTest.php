<?php
/**
 * WorkflowHelper::label()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowHelper::label()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\View\Helper\WorkflowHelper
 */
class WorkflowHelperLabelTest extends NetCommonsHelperTestCase {

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

		//テストデータ生成
		$viewVars = array();
		$requestData = array();

		//Helperロード
		$this->loadHelper('Workflow.Workflow', $viewVars, $requestData);
		$this->assertTrue(class_exists('WorkflowComponent'));
	}

/**
 * label()テストのDataProvider
 *
 * ### 戻り値
 *  - status ステータス
 *  - labels 上書きするラベル配列
 *  - assert 期待値の文字列
 *
 * @return array データ
 */
	public function dataProvider() {
		return array(
			// * 公開
			array('status' => '1', 'labels' => null,
				'assert' => ''),
			// * 申請中
			array('status' => '2', 'labels' => null,
				'assert' => '<span class="label label-warning">' . __d('net_commons', 'Approving') . '</span>'),
			// * 一時保存
			array('status' => '3', 'labels' => null,
				'assert' => '<span class="label label-info">' . __d('net_commons', 'Temporary') . '</span>'),
			// * 差し戻し
			array('status' => '4', 'labels' => null,
				'assert' => '<span class="label label-warning">' . __d('net_commons', 'Disapproving') . '</span>'),
			// * カスタム
			array('status' => '5', 'labels' => array('5' => array('class' => 'label-danger', 'message' => 'Custom')),
				'assert' => '<span class="label label-danger">Custom</span>'),
		);
	}

/**
 * label()のテスト
 *
 * @param int $status ステータス
 * @param array $labels 上書きするラベル配列
 * @param string assert 期待値の文字列
 * @dataProvider dataProvider
 * @return void
 */
	public function testLabel($status, $labels, $assert) {
		//テスト実施
		if (isset($labels)) {
			$result = $this->Workflow->label($status, $labels);
		} else {
			$result = $this->Workflow->label($status);
		}

		//チェック
		$this->assertEquals($assert, $result);
	}

}
