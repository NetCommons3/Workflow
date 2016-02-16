<?php
/**
 * WorkflowGetTestテスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowGetTest', 'Workflow.TestSuite');

/**
 * WorkflowGetTestテスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\TestSuite
 */
class TestSuiteWorkflowGetTest extends WorkflowGetTest {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'test_workflow';

/**
 * setUp method
 *
 * @return mixed テスト結果
 */
	public function setUp() {
		return parent::setUp();
	}

}
