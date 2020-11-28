<!-- Modal Change City -->
<div class="modal fade" id="browseAdminCities" tabindex="-1" role="dialog" aria-labelledby="adminCitiesModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title" id="adminCitiesModalLabel">
					<i class="icon-map"></i> <?php echo e(t('Select your region')); ?>

				</h4>
				
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-xl-12">
						<p id="selectedAdmin"><?php echo e(t('Popular cities in')); ?> <strong><?php echo e(config('country.name')); ?></strong></p>
						<div style="clear:both"></div>
						<div class="col-sm-6 no-padding">
							<form id="modalAdminForm" name="modalAdminForm" method="POST">
								<input type="hidden" id="currSearch" name="curr_search" value="<?php echo e(base64_encode(serialize(request()->except(['l', 'location', '_token'])))); ?>">
								<select class="form-control" id="modalAdminField" name="admin_code">
									<option selected value=""><?php echo e(t('All regions')); ?></option>
									<?php if(isset($modalAdmins) and $modalAdmins->count() > 0): ?>
										<?php $__currentLoopData = $modalAdmins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($admin1->code); ?>"><?php echo e($admin1->name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<?php echo csrf_field(); ?>

							</form>
						</div>
						<div style="clear:both"></div>
						<hr class="hr-thin">
					</div>
					<div class="col-xl-12" id="adminCities"></div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<!-- /.modal -->

<?php $__env->startSection('after_scripts'); ?>
	##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
	<script>
		/* Modal Default Admin1 Code */
        <?php if(isset($city) and !empty($city)): ?>
            var modalDefaultAdminCode = '<?php echo e($city->subadmin1_code); ?>';
        <?php elseif(isset($admin) and !empty($admin)): ?>
            var modalDefaultAdminCode = '<?php echo e($admin->code); ?>';
        <?php else: ?>
            var modalDefaultAdminCode = 0;
        <?php endif; ?>
	</script>
	<script src="<?php echo e(url('assets/js/app/load.cities.js') . vTime()); ?>"></script>
<?php $__env->stopSection(); ?><?php /**PATH /home/developer/public_html/resources/views/layouts/inc/modal/location.blade.php ENDPATH**/ ?>