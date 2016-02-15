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
 * @package NetCommons\Workflow\Test\test_app\Plugin\Workflow\Model
 */
class TestWorkflowBehaviorTableModel extends AppModel {

/**
 * エーリアス
 *
 * @var mixed
 */
	public $alias = 'TestWorkflowBehaviorModel';

/**
 * テーブル名
 *
 * @var mixed
 */
	public $useTable = 'test_workflow_behavior_models';

/**
 * 使用ビヘイビア
 *
 * @var array
 */
	public $actsAs = array(
		'Workflow.Workflow'
	);

}
