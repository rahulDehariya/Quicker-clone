<?php if($xPanel->hasAccess('update')): ?>
	<a href="<?php echo e(url($xPanel->route.'/'.$entry->getKey() . '/edit')); ?>" class="btn btn-xs btn-primary">
		<i class="far fa-edit"></i> <?php echo e(trans('admin.edit')); ?>

    </a>
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/buttons/update.blade.php ENDPATH**/ ?>