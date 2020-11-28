<?php if(isset($cats) and $cats->count() > 0): ?>
	<div class="container hide-xs">
		<div>
			<ul class="list-inline">
				<?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li class="list-inline-item mt-2">
						<?php if(isset($cat) and !empty($cat) and $iCat->tid == $cat->tid): ?>
							<span class="badge badge-primary">
								<?php echo e($iCat->name); ?>

							</span>
						<?php else: ?>
							<a href="<?php echo e(\App\Helpers\UrlGen::category($iCat)); ?>" class="badge badge-light">
								<?php echo e($iCat->name); ?>

							</a>
						<?php endif; ?>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	</div>
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/search/inc/categories-root.blade.php ENDPATH**/ ?>