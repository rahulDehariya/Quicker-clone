<!-- City -->
<div class="block-title has-arrow sidebar-header">
	<h5>
		<span class="font-weight-bold">
			<?php echo e(t('locations')); ?>

		</span>
	</h5>
</div>
<div class="block-content list-filter locations-list">
	<ul class="browse-list list-unstyled long-list">
		<?php if(isset($cities) and $cities->count() > 0): ?>
			<?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php
				$attr = ['countryCode' => config('country.icode')];
				$fullUrlLocation = lurl(trans('routes.v-search', $attr), $attr);
				if (isset($cat) and !empty($cat)) {
					if (isset($cat->parent) and !empty($cat->parent)) {
						$locationParams = [
							'l'  => $city->id,
							'r'  => '',
							'c'  => $cat->tid,
							'sc' => $cat->parent->tid,
						];
					} else {
						$locationParams = [
							'l'  => $city->id,
							'r'  => '',
							'c'  => $cat->tid,
						];
					}
				} else {
					$locationParams = [
						'l'  => $city->id,
						'r'  => '',
					];
				}
				?>
				<li>
					<?php if((isset($uriPathCityId) and $uriPathCityId == $city->id) or (request()->input('l')==$city->id)): ?>
						<strong>
							<a href="<?php echo qsUrl($fullUrlLocation, array_merge(request()->except(['page'] + array_keys($locationParams)), $locationParams), null, false); ?>" title="<?php echo e($city->name); ?>">
								<?php echo e($city->name); ?>

							</a>
						</strong>
					<?php else: ?>
						<a href="<?php echo qsUrl($fullUrlLocation, array_merge(request()->except(['page'] + array_keys($locationParams)), $locationParams), null, false); ?>" title="<?php echo e($city->name); ?>">
							<?php echo e($city->name); ?>

						</a>
					<?php endif; ?>
				</li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</ul>
</div>
<div style="clear:both"></div><?php /**PATH /home/developer/public_html/resources/views/search/inc/sidebar/cities.blade.php ENDPATH**/ ?>