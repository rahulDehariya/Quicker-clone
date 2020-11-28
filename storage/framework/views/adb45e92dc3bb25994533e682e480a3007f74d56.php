<!-- Date -->
<div class="block-title has-arrow sidebar-header">
	<h5>
		<span class="font-weight-bold">
			<?php echo e(t('Date Posted')); ?>

		</span>
	</h5>
</div>
<div class="block-content list-filter">
	<div class="filter-date filter-content">
		<ul>
			<?php if(isset($dates) and !empty($dates)): ?>
				<?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li>
						<input type="radio"
							   name="postedDate"
							   value="<?php echo e($key); ?>"
							   id="postedDate_<?php echo e($key); ?>" <?php echo e((request()->get('postedDate')==$key) ? 'checked="checked"' : ''); ?>

						>
						<label for="postedDate_<?php echo e($key); ?>"><?php echo e($value); ?></label>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
			<input type="hidden" id="postedQueryString" value="<?php echo e(httpBuildQuery(request()->except(['page', 'postedDate']))); ?>">
		</ul>
	</div>
</div>
<div style="clear:both"></div>

<?php $__env->startSection('after_scripts'); ?>
	##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
	
	<script>
		$(document).ready(function ()
		{
			$('input[type=radio][name=postedDate]').click(function() {
				var postedQueryString = $('#postedQueryString').val();
				
				if (postedQueryString != '') {
					postedQueryString = postedQueryString + '&';
				}
				postedQueryString = postedQueryString + 'postedDate=' + $(this).val();
				
				var searchUrl = baseUrl + '?' + postedQueryString;
				redirect(searchUrl);
			});
		});
	</script>
<?php $__env->stopSection(); ?><?php /**PATH /home/developer/public_html/resources/views/search/inc/sidebar/date.blade.php ENDPATH**/ ?>