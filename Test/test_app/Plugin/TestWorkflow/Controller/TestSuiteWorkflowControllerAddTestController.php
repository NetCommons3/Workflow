<?php
/**
 * WorkflowControllerAddTestテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * WorkflowControllerAddTestテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\Controller
 */
class TestSuiteWorkflowControllerAddTestController extends AppController {

/**
 * add
 *
 * @return void
 */
	public function index() {
		$this->autoRender = true;
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->autoRender = true;
		$this->set('username', Current::read('User.username'));
	}

/**
 * add_post
 *
 * @return void
 */
	public function add_post() {
		$this->autoRender = true;
		$this->redirect('index');
	}

/**
 * add_validation_error
 *
 * @return void
 */
	public function add_validation_error() {
		$this->autoRender = true;
	}

}
