<?php
/**
 * comment index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php if (isset($comments) && $comments): ?>
	<div class="panel panel-default" ng-init="more=false">
		<div class="panel-body workflow-comments">
			<?php foreach ($comments as $i => $comment): ?>
				<div class="comment form-group" ng-show="<?php echo $i >= WorkflowComment::START_LIMIT ? 'more' : 'true' ?>">
					<div>
						<?php echo $this->DisplayUser->handleLink($comment, array('avatar' => true)); ?>
						<small class="text-muted"><?php echo $this->Date->dateFormat($comment['WorkflowComment']['created']); ?></small>
					</div>
					<div>
						<?php echo nl2br(h($comment['WorkflowComment']['comment'])) ?>
					</div>
				</div>
			<?php endforeach ?>

			<?php if (count($comments) > WorkflowComment::START_LIMIT) : ?>
				<div class="form-group" ng-hide="more">
					<button type="button" class="btn btn-info btn-block" ng-click="more=true">
						<?php echo __d('net_commons', 'More'); ?>
					</button>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif;
