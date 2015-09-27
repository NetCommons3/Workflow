<?php
/**
 * WorkflowContentEditPostTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * WorkflowContentEditPostTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AuthGeneral\TestSuite
 */
interface WorkflowSaveTest {

/**
 * Modelname::saveXXXXのテスト(WorkflowComponent::STATUS_PUBLISHED)
 *
 * @return void
 */
	public function testSaveByStatusPublished();

/**
 * Modelname::saveXXXXのテスト(WorkflowComponent::STATUS_APPROVED)
 *
 * @return void
 */
	public function testSaveByStatusApproved();

/**
 * Modelname::saveXXXXのテスト(WorkflowComponent::STATUS_IN_DRAFT)
 *
 * @return void
 */
	public function testSaveByStatusInDraft();

/**
 * Modelname::saveXXXXのテスト(WorkflowComponent::STATUS_DISAPPROVED)
 *
 * @return void
 */
	public function testSaveByStatusDisapproved();

/**
 * Modelname::saveのExceptionErrorテスト
 *
 * @return void
 */
	public function testSaveExceptionError();

/**
 * Modelname::saveのValidationErrorテスト
 *
 * @return void
 */
	public function testSaveValidationError();

}
