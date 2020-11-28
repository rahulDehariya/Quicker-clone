<?php
// Default Map's values
$loc = [
	'show'       		=> false,
	'itemsCols'  		=> 3,
	'showButton' 		=> false,
	'countCitiesPosts' 	=> false,
];
$map = ['show' => false];

// Get Admin Map's values
if (isset($citiesOptions)) {
	if (isset($citiesOptions['show_cities']) and $citiesOptions['show_cities'] == '1') {
		$loc['show'] = true;
	}
	if (isset($citiesOptions['items_cols']) and !empty($citiesOptions['items_cols'])) {
		$loc['itemsCols'] = (int)$citiesOptions['items_cols'];
	}
	if (isset($citiesOptions['show_post_btn']) and $citiesOptions['show_post_btn'] == '1') {
		$loc['showButton'] = true;
	}
	
	if (file_exists(config('larapen.core.maps.path') . config('country.icode') . '.svg')) {
		if (isset($citiesOptions['show_map']) and $citiesOptions['show_map'] == '1') {
			$map['show'] = true;
		}
	}
	
	if (isset($citiesOptions['count_cities_posts']) and $citiesOptions['count_cities_posts'] == '1') {
		$loc['countCitiesPosts'] = true;
	}
}
$hideOnMobile = '';
if (isset($citiesOptions, $citiesOptions['hide_on_mobile']) and $citiesOptions['hide_on_mobile'] == '1') {
	$hideOnMobile = ' hidden-sm';
}
?>
<?php if($loc['show'] || $map['show']): ?>
<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container<?php echo e($hideOnMobile); ?>">
	<div class="col-xl-12 page-content p-0">
		<div class="inner-box">
			
			<div class="row">
				<?php if(!$map['show']): ?>
					<div class="row">
						<div class="col-xl-12 col-sm-12">
							<h2 class="title-3 pt-1 pr-3 pb-3 pl-3 " style="white-space: nowrap;">
								<i class="icon-location-2"></i>&nbsp;<?php echo e(t('Choose a city')); ?>

							</h2>
						</div>
					</div>
				<?php endif; ?>
				<?php
				$leftClassCol = '';
				$rightClassCol = '';
				$ulCol = 'col-md-3 col-sm-12'; // Cities Columns
				
				if ($loc['show'] && $map['show']) {
					// Display the Cities & the Map
					$leftClassCol = 'col-lg-8 col-md-12';
					$rightClassCol = 'col-lg-3 col-md-12 mt-3 mt-xl-0 mt-lg-0';
					$ulCol = 'col-md-4 col-sm-6 col-xs-12';
					
					if ($loc['itemsCols'] == 2) {
						$leftClassCol = 'col-md-6 col-sm-12';
						$rightClassCol = 'col-md-5 col-sm-12';
						$ulCol = 'col-md-6 col-sm-12';
					}
					if ($loc['itemsCols'] == 1) {
						$leftClassCol = 'col-md-3 col-sm-12';
						$rightClassCol = 'col-md-8 col-sm-12';
						$ulCol = 'col-xl-12';
					}
				} else {
					if ($loc['show'] && !$map['show']) {
						// Display the Cities & Hide the Map
						$leftClassCol = 'col-xl-12';
					}
					if (!$loc['show'] && $map['show']) {
						// Display the Map & Hide the Cities
						$rightClassCol = 'col-xl-12';
					}
				}
				?>
				<?php if($loc['show']): ?>
				<div class="<?php echo e($leftClassCol); ?> page-content m-0 p-0">
					<?php if(isset($cities)): ?>
						<div class="relative location-content">
							
							<?php if($loc['show'] && $map['show']): ?>
								<h2 class="title-3 pt-1 pr-3 pb-3 pl-3" style="white-space: nowrap;">
									<i class="icon-location-2"></i>&nbsp;<?php echo e(t('Choose a city or region')); ?>

								</h2>
							<?php endif; ?>
							<div class="col-xl-12 tab-inner">
								<div class="row">
									<?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<ul class="cat-list <?php echo e($ulCol); ?> mb-0 mb-xl-2 mb-lg-2 mb-md-2 <?php echo e((count($cities) == $key+1) ? 'cat-list-border' : ''); ?>">
											<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<li>
													<?php if($city->id == 999999999): ?>
														<a href="#browseAdminCities" data-toggle="modal"><?php echo $city->name; ?></a>
													<?php else: ?>
														<a href="<?php echo e(\App\Helpers\UrlGen::city($city)); ?>">
															<?php echo e($city->name); ?>

														</a>
														<?php if($loc['countCitiesPosts']): ?>
															&nbsp;(<?php echo e($city->posts->count()); ?>)
														<?php endif; ?>
													<?php endif; ?>
												</li>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</ul>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>
							</div>
							
							<?php if($loc['showButton']): ?>
								<?php if(!auth()->check() and config('settings.single.guests_can_post_ads') != '1'): ?>
									<a class="btn btn-lg btn-add-listing" href="#quickLogin" data-toggle="modal">
										<i class="fa fa-plus-circle"></i> <?php echo e(t('Add Listing')); ?>

									</a>
								<?php else: ?>
									<a class="btn btn-lg btn-add-listing pl-4 pr-4" href="<?php echo e(\App\Helpers\UrlGen::addPost()); ?>" style="text-transform: none;">
										<i class="fa fa-plus-circle"></i> <?php echo e(t('Add Listing')); ?>

									</a>
								<?php endif; ?>
							<?php endif; ?>
	
						</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				
				<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.svgmap', 'layouts.inc.tools.svgmap'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>
			
		</div>
	</div>
</div>
<?php endif; ?>

<?php $__env->startSection('modal_location'); ?>
	##parent-placeholder-b1a75092d8efb6b73eb42f8bb511a9329ccc7ca3##
	<?php if($loc['show'] || $map['show']): ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.modal.location', 'layouts.inc.modal.location'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php /**PATH /home/developer/public_html/resources/views/home/inc/locations.blade.php ENDPATH**/ ?>