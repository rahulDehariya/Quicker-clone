<?php
// Keywords
$keywords = rawurldecode(request()->get('q'));

// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->tid : request()->get('c');

// Location
if (isset($city) and !empty($city)) {
	$qLocationId = (isset($city->id)) ? $city->id : 0;
	$qLocation = $city->name;
	$qAdmin = request()->get('r');
} else {
	$qLocationId = request()->get('l');
	$qLocation = (request()->filled('r')) ? t('area') . rawurldecode(request()->get('r')) : request()->get('location');
    $qAdmin = request()->get('r');
}
?>
<div class="container">
	<div class="search-row-wrapper rounded">
		<div class="container">
			<?php $attr = ['countryCode' => config('country.icode')]; ?>
			<form id="seach" name="search" action="<?php echo e(lurl(trans('routes.v-search', $attr), $attr)); ?>" method="GET">
				<div class="row m-0">
					
					<div class="col-xl-3 col-md-3 col-sm-12 col-xs-12">
						<select name="c" id="catSearch" class="form-control selecter">
							<option value="" <?php echo e(($qCategory=='') ? 'selected="selected"' : ''); ?>>
								<?php echo e(t('all_categories')); ?>

							</option>
							<?php if(isset($rootCats) and $rootCats->count() > 0): ?>
								<?php $__currentLoopData = $rootCats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option <?php echo e(($qCategory==$itemCat->tid) ? ' selected="selected"' : ''); ?> value="<?php echo e($itemCat->tid); ?>">
										<?php echo e($itemCat->name); ?>

									</option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
					
					<div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
						<input name="q" class="form-control keyword" type="text" placeholder="<?php echo e(t('what')); ?>" value="<?php echo e($keywords); ?>">
					</div>
					
					<div class="col-xl-3 col-md-3 col-sm-12 col-xs-12 search-col locationicon">
						<i class="icon-location-2 icon-append"></i>
						<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
							   placeholder="<?php echo e(t('where')); ?>" value="<?php echo e($qLocation); ?>" title="" data-placement="bottom"
							   data-toggle="tooltip"
							   data-original-title="<?php echo e(t('Enter a city name OR a state name with the prefix', ['prefix' => t('area')]) . t('State Name')); ?>">
					</div>
	
					<input type="hidden" id="lSearch" name="l" value="<?php echo e($qLocationId); ?>">
					<input type="hidden" id="rSearch" name="r" value="<?php echo e($qAdmin); ?>">
	
					<div class="col-xl-2 col-md-2 col-sm-12 col-xs-12">
						<button class="btn btn-block btn-primary">
							<i class="fa fa-search"></i> <strong><?php echo e(t('find')); ?></strong>
						</button>
					</div>
					
					<?php echo csrf_field(); ?>

					
				</div>
			</form>
		</div>
	</div>
</div>

<?php $__env->startSection('after_scripts'); ?>
	##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
	<script>
		$(document).ready(function () {
			$('#locSearch').on('change', function () {
				if ($(this).val() == '') {
					$('#lSearch').val('');
					$('#rSearch').val('');
				}
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH /home/developer/public_html/resources/views/search/inc/form.blade.php ENDPATH**/ ?>