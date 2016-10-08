<?php
/**
 * WorkflowBehaviorテスト用Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');

/**
 * WorkflowBehaviorテスト用Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\Test\test_app\Plugin\TestWorkflow\Model
 */
class TestWorkflowBehaviorGetWorkflowConditionsWOLangModel extends AppModel {

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'test_get_workflow_conditions_w_o_lang_models';

/**
 * Custom database table name, or null/false if no table association is desired.
 *
 * @var string
 * @link http://book.cakephp.org/2.0/ja/models/model-attributes.html#usetable
 */
	public $useTable = 'test_get_workflow_conditions_w_o_lang_models';

/**
 * 使用ビヘイビア
 *
 * @var array
 */
	public $actsAs = array(
		'Workflow.Workflow'
	);

}
