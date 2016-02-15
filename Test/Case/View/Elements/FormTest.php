<?php
/**
 * View/Elements/formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/formのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\View\Elements\Form
 */
class WorkflowViewElementsFormTest extends NetCommonsControllerTestCase {

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

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Workflow', 'TestWorkflow');
		//テストコントローラ生成
		$this->generateNc('TestWorkflow.TestViewElementsForm');
	}

/**
 * View/Elements/formのテスト
 *
 * @return void
 */
	public function testForm() {
		//テスト実行
		$this->_testNcAction('/test_workflow/test_view_elements_form/form', array(
			'method' => 'get'
		));

		//チェック
		$pattern = '/' . preg_quote('View/Elements/form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$placeholder = __d('net_commons', 'Please enter comments to the person in charge.');
		$pattern = '/<textarea name="' . preg_quote('data[WorkflowComment][comment]', '/') . '".*?placeholder="' . $placeholder . '".*?>/';
		$this->assertRegExp($pattern, $this->view);
	}

/**
 * View/Elements/formのテスト(コンテンツ公開権限あり＋承認待ち状態)
 *
 * @return void
 */
	public function testContentPublishableAndApproval() {
		//テスト実行
		$this->_testNcAction('/test_workflow/test_view_elements_form/form_content_publishable', array(
			'method' => 'get'
		));

		//チェック
		$pattern = '/' . preg_quote('View/Elements/form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$placeholder = __d('net_commons', 'If it is not approved, comment is a required input.');
		$pattern = '/<textarea name="' . preg_quote('data[WorkflowComment][comment]', '/') . '".*?placeholder="' . $placeholder . '".*?>/';
		$this->assertRegExp($pattern, $this->view);
	}

}
