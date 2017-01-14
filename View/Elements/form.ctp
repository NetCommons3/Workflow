<?php
/**
 * Workflow comment form element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

if ($contentPublishable && $contentStatus === WorkflowComponent::STATUS_APPROVAL_WAITING) {
	$placeholder = __d('net_commons', 'If it is not approved, comment is a required input.');
} else {
	$placeholder = __d('net_commons', 'Please enter comments to the person in charge.');
}
?>

<div class="row">
	<div class="col-xs-offset-1 col-xs-11">
		<?php echo $this->NetCommonsForm->input('WorkflowComment.comment', array(
				'type' => 'textarea',
				'class' => 'form-control nc-noresize',
				'label' => '<span class="glyphicon glyphicon-comment" aria-hidden="true"> </span> ' .
							__d('net_commons', 'Comments to the person in charge.'),
				'placeholder' => $placeholder,
				'rows' => 2,
			)); ?>
	</div>
</div>
