<?php
/**
 * WorkflowHelper::comments()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * WorkflowHelper::comments()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\Case\View\Helper\WorkflowHelper
 */
class WorkflowHelperCommentsTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.workflow.workflow_comment',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'workflow';

/**
 * comments()のテスト
 *
 * @return void
 */
	public function testComments() {
		//テストデータ生成
		ClassRegistry::init('Workflow.WorkflowComment');
		$viewVars = array();
		$viewVars['comments'][0] = array(
			'WorkflowComment' => array(
				'comment' => 'Workflow Comment',
				'created' => date('Y-m-d H:i:s'),
				'created_user' => '1'
			),
			'TrackableCreator' => array(
				'id' => '1',
				'handlename' => 'Handle name',
			)
		);

		$requestData = array();

		//Helperロード
		$this->loadHelper('Workflow.Workflow', $viewVars, $requestData, array(), array('Users.DisplayUser'));

		//テスト実施
		$result = $this->Workflow->comments();

		//チェック
		$this->assertTextContains('Workflow Comment', $result);
	}

/**
 * comments()のテスト(viewVars['comments']なし)
 *
 * @return void
 */
	public function testWithoutComments() {
		//テストデータ生成
		ClassRegistry::init('Workflow.WorkflowComment');
		$viewVars = array();
		$requestData = array();

		//Helperロード
		$this->loadHelper('Workflow.Workflow', $viewVars, $requestData);

		//テスト実施
		$result = $this->Workflow->comments();

		//チェック
		$this->assertEquals('', trim($result));
	}

}
