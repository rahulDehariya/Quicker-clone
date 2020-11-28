<?php if($xPanel->hasAccess('create')): ?>
	<a href="<?php echo e(url($xPanel->route.'/create')); ?>" class="btn btn-primary shadow ladda-button" data-style="zoom-in">
		<span class="ladda-label">
            <i class="fas fa-plus"></i> <?php echo e(trans('admin.add')); ?> <?php echo $xPanel->entityName; ?>

        </span>
    </a>
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/buttons/create.blade.php ENDPATH**/ ?>