<?php
/**
 * WorkflowControllerDeleteTestテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * WorkflowControllerDeleteTestテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\Controller
 */
class TestSuiteWorkflowControllerDeleteTestController extends AppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Workflow.WorkflowComment',
	);

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		$this->autoRender = true;
		$this->set('workflowCommentCount', $this->WorkflowComment->find('count'));
	}

/**
 * delete_post
 *
 * @return void
 */
	public function delete_post() {
		$this->autoRender = true;
		$this->set('workflowCommentCount', $this->WorkflowComment->find('count'));
		$this->redirect('index');
	}

/**
 * delete_exception_error
 *
 * @return void
 */
	public function delete_exception_error() {
		$this->autoRender = true;
		$this->set('workflowCommentCount', $this->WorkflowComment->find('count'));
		$this->redirect('index');
	}

}
