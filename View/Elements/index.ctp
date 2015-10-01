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
				<div class="comment form-group" ng-show="<?php echo $i >= Comment::START_LIMIT ? 'more' : 'true' ?>">
					<div>
						<a href="" ng-click="user.showUser(<?php echo $comment['TrackableCreator']['id']; ?>)">
							<b><?php echo h($comment['TrackableCreator']['handlename']); ?></b>
						</a>
						<small class="text-muted"><?php echo $comment['Comment']['created']; ?></small>
					</div>
					<div>
						<?php echo nl2br(h($comment['Comment']['comment'])) ?>
					</div>
				</div>
			<?php endforeach ?>

			<div class="form-group <?php echo $i < Comment::START_LIMIT ? 'hidden' : '' ?>" ng-hide="more">
				<button type="button" class="btn btn-info btn-block" ng-click="more=true">
					<?php echo h(__d('net_commons', 'More')); ?>
				</button>
			</div>
		</div>
	</div>
<?php endif;
