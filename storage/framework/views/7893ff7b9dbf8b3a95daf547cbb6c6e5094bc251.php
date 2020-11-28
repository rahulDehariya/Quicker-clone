<?php if (isset($conversation) and !empty($conversation)): ?>
<div class="modal fade" id="replyTo<?php echo e($conversation->id); ?>" tabindex="-1" role="dialog" aria-labelledby="replyTo<?php echo e($conversation->id); ?>Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="replyTo<?php echo e($conversation->id); ?>Label">
					<?php
					$headerTitle = t('Reply to');
					$replyTo = '';
					if (auth()->check()) {
						if (auth()->user()->name != $conversation->from_name) {
							$replyTo = $conversation->from_name;
						} else {
							if (isset($conversation->post->user) && !empty($conversation->post->user)) {
								$replyTo = $conversation->post->user->name;
							} else {
								$replyTo = $conversation->post->contact_name;
							}
						}
					}
					$replyTo = $replyTo ?? '--';
					$headerTitle = $headerTitle . ' "' . $replyTo . '"';
					?>
					<?php echo e($headerTitle); ?>

				</h4>
				
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<form role="form" method="POST" action="<?php echo e(lurl('account/conversations/' . $conversation->id . '/reply')); ?>">
				<?php echo csrf_field(); ?>

				<div class="modal-body enable-long-words">
					<?php if(isset($errors) and $errors->any()): ?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul class="list list-check">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo e($error); ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					<?php endif; ?>
					
					<!-- message -->
					<?php $messageError = (isset($errors) and $errors->has('message')) ? ' is-invalid' : ''; ?>
					<div class="form-group required">
						<label for="message" class="control-label">
							<?php echo e(t('Message')); ?> <span class="text-count">(<?php echo e(t('number_max', ['number' => 500])); ?>)</span> <sup>*</sup>
						</label>
						<textarea name="message"
								  class="form-control required<?php echo e($messageError); ?>"
								  placeholder="<?php echo e(t('your_message_here')); ?>"
								  rows="5"
						><?php echo e(old('message')); ?></textarea>
					</div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(t('Close')); ?></button>
					<button type="submit" class="btn btn-primary"><i class="icon-reply"></i> <?php echo e(t('Reply')); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>

<?php $__env->startSection('after_scripts'); ?>
	##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
	
	<?php if(isset($conversation) and !empty($conversation)): ?>
	<script>
		$(document).ready(function () {
			<?php if($errors->any()): ?>
				$('#replyTo<?php echo e($conversation->id); ?>').modal();
			<?php endif; ?>
		});
	</script>
	<?php endif; ?>
<?php $__env->stopSection(); ?><?php /**PATH /home/developer/public_html/resources/views/account/inc/reply-message.blade.php ENDPATH**/ ?>