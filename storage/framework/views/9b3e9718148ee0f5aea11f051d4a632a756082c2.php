<!-- enum -->
<div <?php echo $__env->make('admin::panel.inc.field_wrapper_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> >
    <label><?php echo $field['label']; ?></label>
    <?php $entity_model = $xPanel->model; ?>
    <select
        name="<?php echo e($field['name']); ?>"
        <?php echo $__env->make('admin::panel.inc.field_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    	>

        <?php if($entity_model::isColumnNullable($field['name'])): ?>
            <option value="">-</option>
        <?php endif; ?>

		<?php if(count($entity_model::getPossibleEnumValues($field['name']))): ?>
			<?php $__currentLoopData = $entity_model::getPossibleEnumValues($field['name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $possible_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($possible_value); ?>"
					<?php if(( old($field['name']) &&  old($field['name']) == $possible_value) || (isset($field['value']) && $field['value']==$possible_value)): ?>
						 selected
					<?php endif; ?>
				><?php echo e($possible_value); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</select>

    
    <?php if(isset($field['hint'])): ?>
        <small class="form-control-feedback"><?php echo $field['hint']; ?></small>
    <?php endif; ?>
</div><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/fields/enum.blade.php ENDPATH**/ ?>