<!-- text input -->
<div <?php echo $__env->make('admin::panel.inc.field_wrapper_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> >
    <label><?php echo $field['label']; ?></label>
    
    <?php if(isset($field['prefix']) || isset($field['suffix'])): ?> <div class="input-group"> <?php endif; ?>
    <?php if(isset($field['prefix'])): ?> <div class="input-group-prepend"><?php echo $field['prefix']; ?></div> <?php endif; ?>
    <input
        type="text"
        name="<?php echo e($field['name']); ?>"
        value="<?php echo e(old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' ))); ?>"
        <?php echo $__env->make('admin::panel.inc.field_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    >
    <?php if(isset($field['suffix'])): ?> <div class="input-group-append"><?php echo $field['suffix']; ?></div> <?php endif; ?>
    <?php if(isset($field['prefix']) || isset($field['suffix'])): ?> </div> <?php endif; ?>
    
    
    <?php if(isset($field['hint'])): ?>
        <small class="form-control-feedback"><?php echo $field['hint']; ?></small>
    <?php endif; ?>
</div>





    





    


<?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/fields/text.blade.php ENDPATH**/ ?>