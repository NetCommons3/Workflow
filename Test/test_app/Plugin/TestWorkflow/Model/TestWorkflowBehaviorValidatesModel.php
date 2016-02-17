<?php
/**
 * WorkflowBehavior::validates()テスト用Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');

/**
 * WorkflowBehavior::validates()テスト用Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\Model
 */
class TestWorkflowBehaviorValidatesModel extends AppModel {

/**
 * 使用ビヘイビア
 *
 * @var array
 */
	public $actsAs = array(
		'Workflow.Workflow'
	);

}
