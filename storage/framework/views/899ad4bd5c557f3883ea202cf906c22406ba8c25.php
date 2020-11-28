<?php if(isset($cat) and !empty($cat)): ?>
	<?php if(isset($cat->children) and $cat->children->count() > 0): ?>
		<div class="container hide-xs">
			<div>
				<ul class="list-inline">
				<?php $__currentLoopData = $cat->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li class="list-inline-item mt-2">
						<a href="<?php echo e(\App\Helpers\UrlGen::category($iSubCat)); ?>" class="badge badge-light">
							<?php echo e($iSubCat->name); ?>

						</a>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
		</div>
	<?php else: ?>
		<?php if(isset($cat->parent, $cat->parent->children) and $cat->parent->children->count() > 0): ?>
			<div class="container hide-xs">
				<div>
					<ul class="list-inline">
						<?php $__currentLoopData = $cat->parent->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li class="list-inline-item mt-2">
								<?php if($iSubCat->tid == $cat->tid): ?>
									<span class="badge badge-primary">
										<?php echo e($iSubCat->name); ?>

									</span>
								<?php else: ?>
									<a href="<?php echo e(\App\Helpers\UrlGen::category($iSubCat)); ?>" class="badge badge-light">
										<?php echo e($iSubCat->name); ?>

									</a>
								<?php endif; ?>
							</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				</div>
			</div>
		<?php else: ?>
			
			<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.categories-root', 'search.inc.categories-root'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			
		<?php endif; ?>
	<?php endif; ?>
<?php else: ?>
	
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.categories-root', 'search.inc.categories-root'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/search/inc/categories.blade.php ENDPATH**/ ?>