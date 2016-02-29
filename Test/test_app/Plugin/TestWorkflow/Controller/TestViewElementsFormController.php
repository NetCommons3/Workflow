<?php
/**
 * View/Elements/formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\Workflow\Controller
 */
class TestViewElementsFormController extends AppController {

/**
 * form
 *
 * @return void
 */
	public function form() {
		$this->autoRender = true;

		$this->set('contentPublishable', false);
		$this->set('contentStatus', '1');
	}

/**
 * form_content_publishable
 *
 * @return void
 */
	public function form_content_publishable() {
		$this->autoRender = true;
		$this->view = 'form';

		$this->set('contentPublishable', true);
		$this->set('contentStatus', '2');
	}

}
