<?php if(isset($cat) and !empty($cat)): ?>
	<?php
	$attr = ['countryCode' => config('country.icode')];
	$searchBaseUrl = lurl(trans('routes.v-search', $attr), $attr);
	$searchUrlWithoutCat = qsUrl($searchBaseUrl, request()->except(['c', 'sc', 'cf']), null, false);
	?>
	
	<!-- SubCategory -->
	<div id="subCatsList">
		<?php if(isset($cat->children) and $cat->children->count() > 0): ?>
			
			<div class="block-title has-arrow sidebar-header">
				<h5>
				<span class="font-weight-bold">
					<?php if(isset($cat->parent) and !empty($cat->parent)): ?>
						<a href="<?php echo e(\App\Helpers\UrlGen::category($cat->parent)); ?>">
							<i class="fas fa-reply"></i> <?php echo e($cat->parent->name); ?>

						</a>
					<?php else: ?>
						<a href="<?php echo e($searchUrlWithoutCat); ?>">
							<i class="fas fa-reply"></i> <?php echo e(t('all_categories')); ?>

						</a>
					<?php endif; ?>
				</span>
				</h5>
			</div>
			<div class="block-content list-filter categories-list">
				<ul class="list-unstyled">
					<li>
						<a href="<?php echo e(\App\Helpers\UrlGen::category($cat)); ?>" title="<?php echo e($cat->name); ?>">
							<span class="title font-weight-bold"><?php echo e($cat->name); ?></span>
							<span class="count">&nbsp;<?php echo e($countPostsByCat->get($cat->tid)->total ?? 0); ?></span>
						</a>
						<ul class="list-unstyled long-list">
							<?php $__currentLoopData = $cat->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li>
									<a href="<?php echo e(\App\Helpers\UrlGen::category($iSubCat)); ?>" title="<?php echo e($iSubCat->name); ?>">
										<?php echo e(\Illuminate\Support\Str::limit($iSubCat->name, 100)); ?>

										<span class="count">(<?php echo e($countPostsByCat->get($iSubCat->tid)->total ?? 0); ?>)</span>
									</a>
								</li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</li>
				</ul>
			</div>
			
		<?php else: ?>
			
			<?php if(isset($cat->parent, $cat->parent->children) and $cat->parent->children->count() > 0): ?>
				<div class="block-title has-arrow sidebar-header">
					<h5>
						<span class="font-weight-bold">
							<?php if(isset($cat->parent->parent) and !empty($cat->parent->parent)): ?>
								<a href="<?php echo e(\App\Helpers\UrlGen::category($cat->parent->parent)); ?>">
									<i class="fas fa-reply"></i> <?php echo e($cat->parent->parent->name); ?>

								</a>
							<?php else: ?>
								<a href="<?php echo e($searchUrlWithoutCat); ?>">
									<i class="fas fa-reply"></i> <?php echo e(t('all_categories')); ?>

								</a>
							<?php endif; ?>
						</span>
					</h5>
				</div>
				<div class="block-content list-filter categories-list">
					<ul class="list-unstyled">
						<?php $__currentLoopData = $cat->parent->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li>
								<?php if($iSubCat->tid == $cat->tid): ?>
									<strong>
										<a href="<?php echo e(\App\Helpers\UrlGen::category($iSubCat)); ?>" title="<?php echo e($iSubCat->name); ?>">
											<?php echo e(\Illuminate\Support\Str::limit($iSubCat->name, 100)); ?>

											<span class="count">(<?php echo e($countPostsByCat->get($iSubCat->tid)->total ?? 0); ?>)</span>
										</a>
									</strong>
								<?php else: ?>
									<a href="<?php echo e(\App\Helpers\UrlGen::category($iSubCat)); ?>" title="<?php echo e($iSubCat->name); ?>">
										<?php echo e(\Illuminate\Support\Str::limit($iSubCat->name, 100)); ?>

										<span class="count">(<?php echo e($countPostsByCat->get($iSubCat->tid)->total ?? 0); ?>)</span>
									</a>
								<?php endif; ?>
							</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				</div>
			<?php else: ?>
				
				<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.categories.root', 'search.inc.sidebar.categories.root'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			
			<?php endif; ?>
			
		<?php endif; ?>
	</div>
	
<?php else: ?>
	
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.categories.root', 'search.inc.sidebar.categories.root'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
<?php endif; ?>
<div style="clear:both"></div><?php /**PATH /home/developer/public_html/resources/views/search/inc/sidebar/categories.blade.php ENDPATH**/ ?>