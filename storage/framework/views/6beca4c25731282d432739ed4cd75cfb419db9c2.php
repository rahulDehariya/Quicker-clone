<!-- textarea -->
<div <?php echo $__env->make('admin::panel.inc.field_wrapper_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> >
    <label><?php echo $field['label']; ?></label>
    <textarea
    	name="<?php echo e($field['name']); ?>"
        <?php echo $__env->make('admin::panel.inc.field_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    	><?php echo e(old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' ))); ?></textarea>

    
    <?php if(isset($field['hint'])): ?>
        <small class="form-control-feedback"><?php echo $field['hint']; ?></small>
    <?php endif; ?>
</div><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/fields/textarea.blade.php ENDPATH**/ ?>