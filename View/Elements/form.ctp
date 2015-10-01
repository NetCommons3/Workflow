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
?>

<div class="row">
	<div class="col-xs-offset-1 col-xs-11">
		<?php echo $this->NetCommonsForm->input('Comment.comment', array(
				'type' => 'textarea',
				'class' => 'form-control nc-noresize',
				'label' => '<span class="glyphicon glyphicon-comment"> </span> ' .
							__d('net_commons', 'Comments to the person in charge.'),
				'placeholder' => ($contentPublishable && $contentStatus === WorkflowComponent::STATUS_APPROVED) ?
										__d('net_commons', 'If it is not approved, comment is a required input.') : __d('net_commons', 'Please enter comments to the person in charge.'),
				'rows' => 2,
			)); ?>
	</div>
</div>
