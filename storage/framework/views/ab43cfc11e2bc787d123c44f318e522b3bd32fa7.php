<?php if($xPanel->hasAccess('show')): ?>
	<a href="<?php echo e(url($xPanel->route.'/'.$entry->getKey())); ?>" class="btn btn-xs btn-secondary"><i class="fa fa-eye"></i> <?php echo e(trans('admin.preview')); ?></a>
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/buttons/preview.blade.php ENDPATH**/ ?>