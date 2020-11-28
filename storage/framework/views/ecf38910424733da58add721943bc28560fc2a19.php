<script src="<?php echo e(asset('vendor/admin/pnotify/pnotify.custom.min.js')); ?>"></script>


<script type="text/javascript">
	jQuery(document).ready(function ($) {
		
		PNotify.prototype.options.styling = "bootstrap3";
		PNotify.prototype.options.styling = "fontawesome";
		
		<?php $__currentLoopData = Alert::getMessages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $messages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			
				$(function () {
					<?php if($message == t('demo_mode_message')): ?>
						new PNotify({
							title: 'Information',
							text: "<?php echo e($message); ?>",
							type: "<?php echo e($type); ?>"
						});
					<?php else: ?>
						new PNotify({
							text: "<?php echo e($message); ?>",
							type: "<?php echo e($type); ?>",
							icon: false
						});
					<?php endif; ?>
				});
			
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	});
</script><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/layouts/inc/alerts.blade.php ENDPATH**/ ?>