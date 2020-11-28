<div id="saveActions" class="form-group">
	
	<input type="hidden" name="save_action" value="<?php echo e($saveAction['active']['value']); ?>">
	
	<div class="btn-group">
		
		<button type="submit" class="btn btn-primary shadow">
			<span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
			<span data-value="<?php echo e($saveAction['active']['value']); ?>"><?php echo e($saveAction['active']['label']); ?></span>
		</button>
		
		<button type="button" class="btn btn-primary shadow dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false">
			<span class="caret"></span>
			<span class="sr-only">Toggle Save Dropdown</span>
		</button>
		
		<div class="dropdown-menu">
			<?php $__currentLoopData = $saveAction['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<a class="dropdown-item" href="javascript:void(0);" data-value="<?php echo e($value); ?>"><?php echo e($label); ?></a>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	
	</div>
	
	<a href="<?php echo e(url($xPanel->route)); ?>" class="btn btn-secondary shadow"><span class="fa fa-ban"></span> &nbsp;<?php echo e(trans('admin.cancel')); ?></a>
</div><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/inc/form_save_buttons.blade.php ENDPATH**/ ?>