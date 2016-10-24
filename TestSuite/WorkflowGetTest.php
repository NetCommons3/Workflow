<?php
/**
 * WorkflowSaveTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowComponent', 'Workflow.Controller/Component');
App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * WorkflowSaveTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\TestSuite
 */
class WorkflowGetTest extends NetCommonsGetTest {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '2';
		Current::$current['Permission']['content_editable']['value'] = true;
		Current::$current['Permission']['content_publishable']['value'] = true;
	}

}
