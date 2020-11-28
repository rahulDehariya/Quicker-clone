<?php if(isset($bottomAdvertising) and !empty($bottomAdvertising)): ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="container">
		<?php
		$responsiveClass = (isset($bottomAdvertising) and $bottomAdvertising->is_responsive != 1) ? ' d-none d-xl-block d-lg-block d-md-none d-sm-none' : '';
		?>
		
		<div class="container mb20 ads-parent-responsive<?php echo e($responsiveClass); ?>">
			<div class="text-center">
				<?php echo $bottomAdvertising->tracking_code_large; ?>

			</div>
		</div>
		<?php if($bottomAdvertising->is_responsive != 1): ?>
			
			<div class="container mb20 ads-parent-responsive d-none d-xl-none d-lg-none d-md-block d-sm-none">
				<div class="text-center">
					<?php echo $bottomAdvertising->tracking_code_medium; ?>

				</div>
			</div>
			
			<div class="container ads-parent-responsive d-block d-xl-none d-lg-none d-md-none d-sm-block">
				<div class="text-center">
					<?php echo $bottomAdvertising->tracking_code_small; ?>

				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/layouts/inc/advertising/bottom.blade.php ENDPATH**/ ?>