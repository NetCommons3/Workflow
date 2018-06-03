<?php
/**
 * View/Elements/indexテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('WorkflowComment', 'Workflow.Model');

/**
 * View/Elements/indexテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\Workflow\Controller
 */
class TestViewElementsIndexController extends AppController {

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Users.DisplayUser',
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->autoRender = true;
		$this->view = 'index';

		$comments = array();
		for ($i = 1; $i <= 3; $i++) {
			$comments[$i] = array(
				'WorkflowComment' => array(
					'comment' => 'Workflow Comment' . $i,
					'created' => date('Y-m-d H:i:s'),
					'created_user' => $i
				),
				'TrackableCreator' => array(
					'id' => $i,
					'handlename' => 'Handle name' . $i,
				)
			);
		}

		$this->set('comments', $comments);
	}

/**
 * index_no_comments
 *
 * @return void
 */
	public function index_no_comment() {
		$this->autoRender = true;
		$this->view = 'index';
	}

/**
 * index_paginator
 *
 * @return void
 */
	public function index_paginator() {
		$this->autoRender = true;
		$this->view = 'index';

		$comments = array();
		for ($i = 1; $i <= 10; $i++) {
			$comments[$i] = array(
				'WorkflowComment' => array(
					'comment' => 'Workflow Comment' . $i,
					'created' => date('Y-m-d H:i:s'),
					'created_user' => $i
				),
				'TrackableCreator' => array(
					'id' => $i,
					'handlename' => 'Handle name' . $i,
				)
			);
		}

		$this->set('comments', $comments);
	}

}
