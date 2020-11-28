<!-- select -->
<div <?php echo $__env->make('admin::panel.inc.field_wrapper_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> >
    <label><?php echo $field['label']; ?></label>
    <select
        name="<?php echo e($field['name']); ?>"
        <?php echo $__env->make('admin::panel.inc.field_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    	>

        <?php if(isset($field['allows_null']) && $field['allows_null']==true): ?>
            <option value="">-</option>
        <?php endif; ?>

		<?php if(isset($field['options']) && !empty($field['options'])): ?>
			<?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($key); ?>"
					<?php if((isset($field['value']) && $key==$field['value']) || ( ! is_null( old($field['name']) ) && old($field['name']) == $key) ): ?>
						 selected
					<?php endif; ?>
				><?php echo e($value); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</select>

    
    <?php if(isset($field['hint'])): ?>
        <small class="form-control-feedback"><?php echo $field['hint']; ?></small>
    <?php endif; ?>
</div><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/fields/select_from_array.blade.php ENDPATH**/ ?>