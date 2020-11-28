<?php if(isset($parent) and !empty($parent)): ?>
	<?php if(!empty($parent->parent)): ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.category.parent', 'post.createOrEdit.inc.category.parent'], ['parent' => $parent->parent], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		&nbsp;&raquo;&nbsp;
	<?php endif; ?>
	<?php if(isset($parent->children) and $parent->children->count() > 0): ?>
		<a href="#browseCategories" data-toggle="modal" class="cat-link" data-id="<?php echo e($parent->tid); ?>">
			<?php echo e($parent->name); ?>

		</a>
	<?php else: ?>
		<?php echo e($parent->name); ?>&nbsp;
		[ <a href="#browseCategories"
			 data-toggle="modal"
			 class="cat-link"
			 data-id="<?php echo e((isset($parent->parent) and !empty($parent->parent)) ? $parent->parent->tid : 0); ?>"
		><i class="far fa-edit"></i> <?php echo e(t('Edit')); ?></a> ]
	<?php endif; ?>
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/post/createOrEdit/inc/category/parent.blade.php ENDPATH**/ ?>