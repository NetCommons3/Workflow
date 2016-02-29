<?php
/**
 * WorkflowControllerEditTestテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * WorkflowControllerEditTestテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\Controller
 */
class TestSuiteWorkflowControllerEditTestController extends AppController {

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$this->autoRender = true;
		$this->set('username', Current::read('User.username'));
	}

/**
 * edit_post
 *
 * @return void
 */
	public function edit_post() {
		$this->autoRender = true;
		$this->redirect('index');
	}

/**
 * edit_validation_error
 *
 * @return void
 */
	public function edit_validation_error() {
		$this->autoRender = true;
	}

}
