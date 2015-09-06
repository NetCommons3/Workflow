<?php
/**
 * Workflow Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * Workflow Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Controller\Component
 */
class WorkflowComponent extends Component {

/**
 * status published
 *
 * @var string
 */
	const STATUS_PUBLISHED = '1';

/**
 * status approved
 *
 * @var string
 */
	const STATUS_APPROVED = '2';

/**
 * in draft status
 *
 * @var string
 */
	const STATUS_IN_DRAFT = '3';

/**
 * status disaproved
 *
 * @var string
 */
	const STATUS_DISAPPROVED = '4';

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Controller with components to initialize
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::initialize
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}

/**
 * Parse content status from request
 *
 * @return mixed status on success, false on error
 * @throws BadRequestException
 */
	public function parseStatus() {
		if ($matches = preg_grep('/^save_\d/', array_keys($this->controller->data))) {
			list(, $status) = explode('_', array_shift($matches));
		} else {
			if ($this->controller->request->is('ajax')) {
				$error = array('error' => array(
					'validationErrors' => array(
						'status' => __d('net_commons', 'Invalid request.')
					)
				));
				$this->controller->renderJson($error, __d('net_commons', 'Bad Request'), 400);
			} else {
				throw new BadRequestException(__d('net_commons', 'Bad Request'));
			}
			return false;
		}

		return $status;
	}

/**
 * Return all statuses
 *
 * @return array status on success, false on error
 */
	public static function getStatuses() {
		return array(
			self::STATUS_PUBLISHED => __d('net_commons', 'Published'),
			self::STATUS_APPROVED => __d('net_commons', 'Approving'),
			self::STATUS_IN_DRAFT => __d('net_commons', 'Temporary'),
			self::STATUS_DISAPPROVED => __d('net_commons', 'Disapproving'),
		);
	}

}
