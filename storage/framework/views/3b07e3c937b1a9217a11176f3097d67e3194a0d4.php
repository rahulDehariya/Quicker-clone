<?php if(config('services.googlemaps.key')): ?>
	<div class="intro-inner">
		<div class="contact-intro">
			<div class="w100 map">
				<iframe id="googleMaps" src="" width="100%" height="350" frameborder="0" style="border:0; pointer-events:none;"></iframe>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php $__env->startSection('after_scripts'); ?>
	##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
	<?php if(config('services.googlemaps.key')): ?>
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(config('services.googlemaps.key')); ?>" type="text/javascript"></script>
	<script>
		$(document).ready(function () {
			getGoogleMaps(
				'<?php echo e(config('services.googlemaps.key')); ?>',
				'<?php echo e((isset($city) and !empty($city)) ? addslashes($city->name) . ',' . config('country.name') : config('country.name')); ?>',
				'<?php echo e(config('app.locale')); ?>'
			);
		})
	</script>
	<?php endif; ?>
<?php $__env->stopSection(); ?><?php /**PATH /home/developer/public_html/resources/views/pages/inc/contact-intro.blade.php ENDPATH**/ ?>