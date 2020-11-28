<!-- Modal Select Category -->
<div class="modal fade" id="browseCategories" tabindex="-1" role="dialog" aria-labelledby="categoriesModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title" id="categoriesModalLabel">
					<i class="icon-map"></i> <?php echo e(t('select_a_category')); ?>

				</h4>
				
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-xl-12" id="selectCats"></div>
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
	<?php /*<script src="{{ url('assets/js/app/load.cities.js') . vTime() }}"></script>*/ ?>
<?php $__env->stopSection(); ?><?php /**PATH /home/developer/public_html/resources/views/post/createOrEdit/inc/category-modal.blade.php ENDPATH**/ ?>