<?php
/**
 * WorkflowHelper::buttons()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowHelper::buttons()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\View\Helper\WorkflowHelper
 */
class WorkflowHelperButtonsTest extends NetCommonsHelperTestCase {

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
		Current::$current = Hash::insert(Current::$current, 'Plugin', array(
			'key' => 'workflow', 'default_action' => 'workflow_ctrl/index', 'type' => '1'
		));
	}

/**
 * buttons()のテスト用DataProvider
 *
 * ### 戻り値
 *  - status ステータス
 *  - contentPublishable コンテンツの公開権限
 *  - cancelUrl キャンセルURL
 *  - panel パネルタグの有無
 *  - backUrl 戻るURL
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array('status' => null, 'contentPublishable' => true,
				'cancelUrl' => null, 'panel' => true, 'backUrl' => null),

			array('status' => null, 'contentPublishable' => false,
				'cancelUrl' => null, 'panel' => true, 'backUrl' => null),

			array('status' => '2', 'contentPublishable' => true,
				'cancelUrl' => null, 'panel' => true, 'backUrl' => null),

			array('status' => '1', 'contentPublishable' => true,
				'cancelUrl' => '/workflow/custom_ctrl/index', 'panel' => true, 'backUrl' => null),

			array('status' => '1', 'contentPublishable' => true,
				'cancelUrl' => null, 'panel' => false, 'backUrl' => null),

			array('status' => '1', 'contentPublishable' => true,
				'cancelUrl' => null, 'panel' => false, 'backUrl' => '/workflow/workflow_ctrl/back'),
		);
	}

/**
 * buttons()のテスト
 *
 * @param int $status ステータス
 * @param bool $contentPublishable コンテンツの公開権限
 * @param string $cancelUrl キャンセルURL
 * @param bool $panel パネルタグの有無
 * @param string $backUrl 戻るURL
 * @dataProvider dataProvider
 * @return void
 */
	public function testButtons($status, $contentPublishable, $cancelUrl, $panel, $backUrl) {
		//テストデータ生成
		Current::$current = Hash::insert(
			Current::$current, 'Permission.content_publishable.value', $contentPublishable
		);

		$viewVars = array();
		$requestData = array(
			'Workflow' => array('status' => $status)
		);

		//Helperロード
		$this->loadHelper('Workflow.Workflow', $viewVars, $requestData);
		$statusFieldName = 'Workflow.status';

		//テスト実施
		$result = $this->Workflow->buttons($statusFieldName, $cancelUrl, $panel, $backUrl);

		//チェック
		if (! $cancelUrl) {
			$cancelUrl = '/workflow/workflow_ctrl/index';
		}
		$this->__assertButtons($result,
			$panel, $cancelUrl, $backUrl,
			($contentPublishable && $status === '2'),
			$contentPublishable
		);
	}

/**
 * buttons()のテスト
 *
 * @param string $result 結果
 * @param bool $panel パネルのタグを有無
 * @param string $cancelUrl キャンセルURL
 * @param string $backUrl 戻るURL
 * @param bool $disapproval 差し戻しかどうか
 * @param bool $approval 決定かどうか
 * @return void
 */
	private function __assertButtons($result, $panel, $cancelUrl, $backUrl, $disapproval, $approval) {
		//パネルのチェック
		if ($panel) {
			$this->assertTextContains('<div class="panel-footer text-center">', $result);
		} else {
			$this->assertTextNotContains('<div class="panel-footer text-center">', $result);
		}

		//キャンセルのチェック
		$expected = '<a href="' . $cancelUrl . '" class="btn btn-default btn-workflow" ' .
							'ng-class="{disabled: sending}" ng-click="sending=true">' .
						'<span class="glyphicon glyphicon-remove"></span> ' . __d('net_commons', 'Cancel') .
					'</a>';
		$this->assertTextContains($expected, $result);

		//戻るのチェック
		if ($backUrl) {
			$expected = '<a href="' . $backUrl . '" class="btn btn-default btn-workflow">' .
							'<span class="glyphicon glyphicon-chevron-left"></span> ' . __d('net_commons', 'BACK') .
						'</a>';
			$this->assertTextContains($expected, $result);
		} else {
			$expected = '<span class="glyphicon glyphicon-chevron-left"></span>';
			$this->assertTextNotContains($expected, $result);
		}

		//一時保存のチェック
		$expected = '<button class="btn btn-info btn-workflow" name="save_3" ng-class="{disabled: sending}" type="submit">' .
						__d('net_commons', 'Save temporally') .
					'</button>';
		if ($disapproval) {
			$this->assertTextNotContains($expected, $result);
		} else {
			$this->assertTextContains($expected, $result);
		}

		//差し戻しのチェック
		$expected = '<button class="btn btn-warning btn-workflow" name="save_4" ng-class="{disabled: sending}" type="submit">' .
						__d('net_commons', 'Disapproval') .
					'</button>';
		if ($disapproval) {
			$this->assertTextContains($expected, $result);
		} else {
			$this->assertTextNotContains($expected, $result);
		}

		//公開のチェック
		$expected = '<button class="btn btn-primary btn-workflow" name="save_1" ng-class="{disabled: sending}" type="submit">' .
						__d('net_commons', 'OK') .
					'</button>';
		if ($approval) {
			$this->assertTextContains($expected, $result);
		} else {
			$this->assertTextNotContains($expected, $result);
		}

		//申請のチェック
		$expected = '<button class="btn btn-primary btn-workflow" name="save_2" ng-class="{disabled: sending}" type="submit">' .
						__d('net_commons', 'OK') .
					'</button>';
		if ($approval) {
			$this->assertTextNotContains($expected, $result);
		} else {
			$this->assertTextContains($expected, $result);
		}
	}

}
