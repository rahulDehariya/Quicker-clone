<?php if(isset($hasChildren) and !$hasChildren): ?>
	
	<?php if(isset($category) and !empty($category)): ?>
		<?php if(!empty($category->parent)): ?>
			<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.category.parent', 'post.createOrEdit.inc.category.parent'], ['parent' => $category->parent], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			&nbsp;&raquo;&nbsp;
		<?php endif; ?>
		<?php if(isset($category->children) and $category->children->count() > 0): ?>
			<a href="#browseCategories" data-toggle="modal" class="cat-link" data-id="<?php echo e($category->tid); ?>">
				<?php echo e($category->name); ?>

			</a>
		<?php else: ?>
			<?php echo e($category->name); ?>&nbsp;
			[ <a href="#browseCategories"
				 data-toggle="modal"
				 class="cat-link"
				 data-id="<?php echo e((isset($category->parent) and !empty($category->parent)) ? $category->parent->tid : 0); ?>"
			><i class="far fa-edit"></i> <?php echo e(t('Edit')); ?></a> ]
		<?php endif; ?>
	<?php else: ?>
		<a href="#browseCategories" data-toggle="modal" class="cat-link" data-id="0">
			<?php echo e(t('select_a_category')); ?>

		</a>
	<?php endif; ?>
	
<?php else: ?>

	<?php if(isset($category) and !empty($category)): ?>
		<p>
			<a href="#" class="btn btn-sm btn-success cat-link" data-id="<?php echo e($category->parent_id); ?>">
				<i class="fas fa-reply"></i> <?php echo e(t('go_to_parent_categories')); ?>

			</a>&nbsp;
			<strong><?php echo e($category->name); ?></strong>
		</p>
		<div style="clear:both"></div>
	<?php endif; ?>
	
	<?php if(isset($categoriesOptions) and isset($categoriesOptions['type_of_display'])): ?>
		<div class="col-xl-12 content-box layout-section">
			<div class="row row-featured row-featured-category">
				<?php if($categoriesOptions['type_of_display'] == 'c_picture_icon'): ?>
					
					<?php if(isset($categories) and $categories->count() > 0): ?>
						<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 f-category">
								<a href="#" class="cat-link" data-id="<?php echo e($cat->tid); ?>">
									<img src="<?php echo e(imgUrl($cat->picture, 'cat')); ?>" class="lazyload img-fluid" alt="<?php echo e($cat->name); ?>">
									<h6>
										<?php echo e($cat->name); ?>

									</h6>
								</a>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
				
				<?php elseif(in_array($categoriesOptions['type_of_display'], ['cc_normal_list', 'cc_normal_list_s'])): ?>
					
					<div style="clear: both;"></div>
					<?php $styled = ($categoriesOptions['type_of_display'] == 'cc_normal_list_s') ? ' styled' : ''; ?>
					
					<?php if(isset($categories) and $categories->count() > 0): ?>
						<div class="col-xl-12">
							<div class="list-categories-children<?php echo e($styled); ?>">
								<div class="row">
									<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cols): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<div class="col-md-4 col-sm-4 <?php echo e((count($categories) == $key+1) ? 'last-column' : ''); ?>">
											<?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												
												<?php
												$randomId = '-' . substr(uniqid(rand(), true), 5, 5);
												?>
												
												<div class="cat-list">
													<h3 class="cat-title rounded">
														<?php if(isset($categoriesOptions['show_icon']) and $categoriesOptions['show_icon'] == 1): ?>
															<i class="<?php echo e($iCat->icon_class ?? 'icon-ok'); ?>"></i>&nbsp;
														<?php endif; ?>
														<a href="#" class="cat-link" data-id="<?php echo e($iCat->tid); ?>">
															<?php echo e($iCat->name); ?>

														</a>
														<span class="btn-cat-collapsed collapsed"
															  data-toggle="collapse"
															  data-target=".cat-id-<?php echo e($iCat->id . $randomId); ?>"
															  aria-expanded="false"
														>
																<span class="icon-down-open-big"></span>
															</span>
													</h3>
													<ul class="cat-collapse collapse show cat-id-<?php echo e($iCat->id . $randomId); ?> long-list-home">
														<?php if(isset($subCategories) and $subCategories->has($iCat->tid)): ?>
															<?php $__currentLoopData = $subCategories->get($iCat->tid); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<li>
																	<a href="#" class="cat-link" data-id="<?php echo e($iSubCat->tid); ?>">
																		<?php echo e($iSubCat->name); ?>

																	</a>
																</li>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														<?php endif; ?>
													</ul>
												</div>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>
							</div>
							<div style="clear: both;"></div>
						</div>
					<?php endif; ?>
				
				<?php else: ?>
					
					<?php
					$listTab = [
						'c_circle_list' => 'list-circle',
						'c_check_list'  => 'list-check',
						'c_border_list' => 'list-border',
					];
					$catListClass = (isset($listTab[$categoriesOptions['type_of_display']])) ? 'list ' . $listTab[$categoriesOptions['type_of_display']] : 'list';
					?>
					<?php if(isset($categories) and $categories->count() > 0): ?>
						<div class="col-xl-12">
							<div class="list-categories">
								<div class="row">
									<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<ul class="cat-list <?php echo e($catListClass); ?> col-md-4 <?php echo e((count($categories) == $key+1) ? 'cat-list-border' : ''); ?>">
											<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<li>
													<?php if(isset($categoriesOptions['show_icon']) and $categoriesOptions['show_icon'] == 1): ?>
														<i class="<?php echo e($cat->icon_class ?? 'icon-ok'); ?>"></i>&nbsp;
													<?php endif; ?>
													<a href="#" class="cat-link" data-id="<?php echo e($cat->tid); ?>">
														<?php echo e($cat->name); ?>

													</a>
												</li>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</ul>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				
				<?php endif; ?>
			
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>

<?php $__env->startSection('before_scripts'); ?>
	##parent-placeholder-094e37d5f5003ce853bb823b74f26393141d779d##
	<?php if(isset($categoriesOptions) and isset($categoriesOptions['max_sub_cats']) and $categoriesOptions['max_sub_cats'] >= 0): ?>
		<script>
			var maxSubCats = <?php echo e((int)$categoriesOptions['max_sub_cats']); ?>;
		</script>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php /**PATH /home/developer/public_html/resources/views/post/createOrEdit/inc/category/select.blade.php ENDPATH**/ ?>