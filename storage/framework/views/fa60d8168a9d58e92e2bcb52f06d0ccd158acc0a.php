<!-- checkbox field -->
<div <?php echo $__env->make('admin::panel.inc.field_wrapper_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> >
    <div class="checkbox">
    	<label>
    	  <input type="hidden" name="<?php echo e($field['name']); ?>" value="0">
    	  <input type="checkbox" value="1"

          name="<?php echo e($field['name']); ?>"

          <?php if(isset($field['value'])): ?>
            <?php if( ((int) $field['value'] == 1 || old($field['name']) == 1) && old($field['name']) !== '0' ): ?>
             checked="checked"
            <?php endif; ?>
          <?php elseif(isset($field['default']) && $field['default']): ?>
            checked="checked"
          <?php endif; ?>

          <?php if(isset($field['attributes'])): ?>
              <?php $__currentLoopData = $field['attributes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    			<?php echo e($attribute); ?>="<?php echo e($value); ?>"
        	  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
          > <?php echo $field['label']; ?>

    	</label>

        
        <?php if(isset($field['hint'])): ?>
			<br>
			<small class="form-control-feedback"><?php echo $field['hint']; ?></small>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/fields/checkbox.blade.php ENDPATH**/ ?>