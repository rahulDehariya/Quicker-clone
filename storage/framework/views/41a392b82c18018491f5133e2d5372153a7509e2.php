<?php
$var_name = str_replace('[]', '', $field['name']);
$var_name = str_replace('][', '.', $var_name);
$var_name = str_replace('[', '.', $var_name);
$var_name = str_replace(']', '', $var_name);
$required = (isset($field['rules']) && isset($field['rules'][$var_name]) && in_array('required', explode('|', $field['rules'][$var_name]))) ? true : '';
?>
<?php if(isset($field['wrapperAttributes'])): ?>
    <?php $__currentLoopData = $field['wrapperAttributes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    	<?php if(is_string($attribute)): ?>
			<?php if($attribute == 'class' and isset($field['type']) and $field['type'] == 'image'): ?>
        		<?php echo e($attribute); ?>="<?php echo e($value); ?> image"
			<?php else: ?>
				<?php echo e($attribute); ?>="<?php echo e($value); ?>"
			<?php endif; ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(!isset($field['wrapperAttributes']['class'])): ?>
		<?php if(isset($field['type']) and $field['type'] == 'image'): ?>
			class="form-group col-md-12 image<?php echo e($errors->has($var_name) ? ' has-error' : ''); ?>"
		<?php else: ?>
			class="form-group col-md-12<?php echo e($errors->has($var_name) ? ' has-error' : ''); ?>"
		<?php endif; ?>
    <?php endif; ?>
<?php else: ?>
	<?php if(isset($field['type']) and $field['type'] == 'image'): ?>
		class="form-group col-md-12 image<?php echo e($errors->has($var_name) ? ' has-error' : ''); ?>"
	<?php else: ?>
		class="form-group col-md-12<?php echo e($errors->has($var_name) ? ' has-error' : ''); ?>"
	<?php endif; ?>
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/inc/field_wrapper_attributes.blade.php ENDPATH**/ ?>