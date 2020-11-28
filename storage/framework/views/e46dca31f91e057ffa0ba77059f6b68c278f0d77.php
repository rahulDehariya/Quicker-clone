<!-- Modal Change Country -->
<div class="modal fade modalHasList" id="selectCountry" tabindex="-1" role="dialog" aria-labelledby="selectCountryLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title uppercase font-weight-bold" id="selectCountryLabel">
					<i class="icon-map"></i> <?php echo e(t('Select your Country')); ?>

				</h4>
				
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row">
					
					<?php if(isset($countryCols)): ?>
						<?php $__currentLoopData = $countryCols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<ul class="cat-list col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-6">
								<?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$countryLang = App\Helpers\Localization\Country::getLangFromCountry($country->get('languages'));
									?>
								<li>
									<img src="<?php echo e(url('images/blank.gif') . getPictureVersion()); ?>" class="flag flag-<?php echo e(($country->get('icode')=='uk') ? 'gb' : $country->get('icode')); ?>" style="margin-bottom: 4px; margin-right: 5px;">
									<a href="<?php echo e(localUrl($country, '', true)); ?>" class="tooltip-test" title="<?php echo e($country->get('name')); ?>">
										<?php echo e(\Illuminate\Support\Str::limit($country->get('name'), 28)); ?>

									</a>
								</li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
					
				</div>
			</div>
			
		</div>
	</div>
</div>
<!-- /.modal -->
<?php /**PATH /home/developer/public_html/resources/views/layouts/inc/modal/change-country.blade.php ENDPATH**/ ?>