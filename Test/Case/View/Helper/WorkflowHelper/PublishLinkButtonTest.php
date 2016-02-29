<?php
/**
 * WorkflowHelper::publishLinkButton()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowHelper::publishLinkButton()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\View\Helper\WorkflowHelper
 */
class WorkflowHelperPublishLinkButtonTest extends NetCommonsHelperTestCase {

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
	}

/**
 * publishLinkButton()のテスト(タイトルテスト)のDataProvider
 *
 * ### 戻り値
 *  - title タイトル
 *
 * @return array データ
 */
	public function dataProviderTitle() {
		return array(
			array('title' => ''),
			array('title' => 'Input Title')
		);
	}

/**
 * publishLinkButton()のテスト(タイトルテスト)
 *
 * @param string $title タイトル
 * @dataProvider dataProviderTitle
 * @return void
 */
	public function testPublishLinkButtonWithTitle($title) {
		//データ生成
		$options = array();

		//テスト実施
		$result = $this->Workflow->publishLinkButton($title, $options);

		//チェック
		$expected = '<button icon="ok" name="save_1" class="btn btn-warning" type="submit">' .
						'<span class="glyphicon glyphicon-ok"></span> ' . $title .
					'</button>';
		$this->assertEqual($expected, $result);
	}

/**
 * publishLinkButton()のテスト(iconSizeのテスト)のDataProvider
 *
 * ### 戻り値
 *  - iconSize タイトル
 *
 * @return array データ
 */
	public function dataProviderIconSize() {
		return array(
			array('iconSize' => ''),
			array('iconSize' => 'glyphicon-xs')
		);
	}

/**
 * publishLinkButton()のテスト(iconSizeのテスト)
 *
 * @param string $iconSize アイコンサイズ
 * @dataProvider dataProviderIconSize
 * @return void
 */
	public function testPublishLinkButtonWithIconSize($iconSize) {
		//データ生成
		$title = '';
		if (isset($iconSize)) {
			$options = array('iconSize' => $iconSize);
		}

		//テスト実施
		$result = $this->Workflow->publishLinkButton($title, $options);

		//チェック
		if ($iconSize) {
			$expectedIconSize = ' ' . $iconSize;
		} else {
			$expectedIconSize = '';
		}
		$expected = '<button icon="ok" name="save_1" class="btn btn-warning' . $expectedIconSize . '" type="submit">' .
						'<span class="glyphicon glyphicon-ok"></span> ' .
					'</button>';
		$this->assertEqual($expected, $result);
	}

/**
 * publishLinkButton()のテスト(タイトルのエスケープテスト)のDataProvider
 *
 * ### 戻り値
 *  - title タイトル
 *  - escapeTitle タイトルをエスケープするか
 *  - expectedTitle 期待値のタイトル
 *
 * @return array データ
 */
	public function dataProviderEscapeTitle() {
		return array(
			array('title' => '<Input Title>', 'escapeTitle' => true, '&lt;Input Title&gt;'),
			array('title' => '<Input Title>', 'escapeTitle' => false, '<Input Title>')
		);
	}

/**
 * publishLinkButton()のテスト(タイトルのエスケープテスト)
 *
 * @param string $title タイトル
 * @param bool $escapeTitle タイトルをエスケープするか
 * @param string $expectedTitle 期待値のタイトル
 * @dataProvider dataProviderEscapeTitle
 * @return void
 */
	public function testPublishLinkButtonWithEscapeTitle($title, $escapeTitle, $expectedTitle) {
		//データ生成
		$options = array('escapeTitle' => $escapeTitle);

		//テスト実施
		$result = $this->Workflow->publishLinkButton($title, $options);

		//チェック
		$expected = '<button icon="ok" name="save_1" class="btn btn-warning" type="submit">' .
						'<span class="glyphicon glyphicon-ok"></span> ' . $expectedTitle .
					'</button>';
		$this->assertEqual($expected, $result);
	}

/**
 * publishLinkButton()のテスト(iconSizeのテスト)のDataProvider
 *
 * ### 戻り値
 *  - tooltip ツールチップ
 *
 * @return array データ
 */
	public function dataProviderTooltip() {
		return array(
			array('tooltip' => true),
			array('tooltip' => 'Input Tooltip')
		);
	}

/**
 * publishLinkButton()のテスト(ツールチップテスト)
 *
 * @param string|bool $tooltip ツールチップ
 * @dataProvider dataProviderTooltip
 * @return void
 */
	public function testPublishLinkButtonWithTooltip($tooltip) {
		//データ生成
		$options = array('tooltip' => $tooltip);

		//テスト実施
		$result = $this->Workflow->publishLinkButton('', $options);

		//チェック
		if (is_bool($tooltip)) {
			$tooltip = __d('net_commons', 'Accept');
		}
		$expected = '<span class="nc-tooltip" tooltip="' . $tooltip . '">' .
				'<button icon="ok" name="save_1" class="btn btn-warning" type="submit">' .
					'<span class="glyphicon glyphicon-ok"></span> ' .
				'</button>' . '</span>';
		$this->assertEqual($expected, $result);
	}

}
