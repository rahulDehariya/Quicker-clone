<?php if(isset($cat) and !empty($cat)): ?>
	<?php if(!in_array($cat->type, ['not-salable'])): ?>
		<!-- Price -->
		<div class="block-title has-arrow sidebar-header">
			<h5>
				<span class="font-weight-bold">
					<?php echo e((!in_array($cat->type, ['job-offer', 'job-search'])) ? t('price_range') : t('salary_range')); ?>

				</span>
			</h5>
		</div>
		<div class="block-content list-filter">
			<form role="form" class="form-inline" action="<?php echo e(request()->url()); ?>" method="GET">
				<?php echo csrf_field(); ?>

				<?php $__currentLoopData = request()->except(['page', 'minPrice', 'maxPrice', '_token']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if(is_array($value)): ?>
						<?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(is_array($v)): ?>
								<?php $__currentLoopData = $v; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ik => $iv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if(is_array($iv)) continue; ?>
									<input type="hidden" name="<?php echo e($key.'['.$k.']['.$ik.']'); ?>" value="<?php echo e($iv); ?>">
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
								<input type="hidden" name="<?php echo e($key.'['.$k.']'); ?>" value="<?php echo e($v); ?>">
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php else: ?>
						<input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
					<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<div class="form-group col-sm-4 no-padding">
					<input type="text" placeholder="2000" id="minPrice" name="minPrice" class="form-control" value="<?php echo e(request()->get('minPrice')); ?>">
				</div>
				<div class="form-group col-sm-1 no-padding text-center hidden-xs"> -</div>
				<div class="form-group col-sm-4 no-padding">
					<input type="text" placeholder="3000" id="maxPrice" name="maxPrice" class="form-control" value="<?php echo e(request()->get('maxPrice')); ?>">
				</div>
				<div class="form-group col-sm-3 no-padding">
					<button class="btn btn-default pull-right btn-block-xs" type="submit"><?php echo e(t('go')); ?></button>
				</div>
			</form>
		</div>
		<div style="clear:both"></div>
	<?php endif; ?>
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/search/inc/sidebar/price.blade.php ENDPATH**/ ?>