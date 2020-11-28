<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.optimization.cache_expiration');
}
$hideOnMobile = '';
if (isset($featuredOptions, $featuredOptions['hide_on_mobile']) and $featuredOptions['hide_on_mobile'] == '1') {
	$hideOnMobile = ' hidden-sm';
}
?>
<?php if(isset($featured) and !empty($featured) and !empty($featured->posts)): ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="container<?php echo e($hideOnMobile); ?>">
		<div class="col-xl-12 content-box layout-section">
			<div class="row row-featured row-featured-category">
				<div class="col-xl-12 box-title">
					<div class="inner">
						<h2>
							<span class="title-3"><?php echo $featured->title; ?></span>
							<a href="<?php echo e($featured->link); ?>" class="sell-your-item">
								<?php echo e(t('View more')); ?> <i class="icon-th-list"></i>
							</a>
						</h2>
					</div>
				</div>
		
				<div style="clear: both"></div>
		
				<div class="relative content featured-list-row clearfix">
					
					<div class="large-12 columns">
						<div class="no-margin featured-list-slider owl-carousel owl-theme">
							<?php
							foreach($featured->posts as $key => $post):
								if (empty($countries) or !$countries->has($post->country_code)) continue;
			
								// Picture setting
								$pictures = \App\Models\Picture::where('post_id', $post->id)->orderBy('position')->orderBy('id');
								if ($pictures->count() > 0) {
									$postImg = imgUrl($pictures->first()->filename, 'medium');
								} else {
									$postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
								}
			
								// Category
								$cacheId = 'category.' . $post->category_id . '.' . config('app.locale');
								$liveCat = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
									$liveCat = \App\Models\Category::find($post->category_id);
									return $liveCat;
								});
								?>
								<div class="item">
									<a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>">
										<span class="item-carousel-thumb">
											<img class="img-fluid" src="<?php echo e($postImg); ?>" alt="<?php echo e($post->title); ?>" style="border: 1px solid #e7e7e7; margin-top: 2px;">
										</span>
										<span class="item-name"><?php echo e(\Illuminate\Support\Str::limit($post->title, 70)); ?></span>
										
										<?php if(config('plugins.reviews.installed')): ?>
											<?php if(view()->exists('reviews::ratings-list')): ?>
												<?php echo $__env->make('reviews::ratings-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
											<?php endif; ?>
										<?php endif; ?>
										
										<span class="price">
											<?php if(isset($liveCat->type)): ?>
												<?php if(!in_array($liveCat->type, ['not-salable'])): ?>
													<?php if($post->price > 0): ?>
														<?php echo \App\Helpers\Number::money($post->price); ?>

													<?php else: ?>
														<?php echo \App\Helpers\Number::money('--'); ?>

													<?php endif; ?>
												<?php endif; ?>
											<?php else: ?>
												<?php echo e('--'); ?>

											<?php endif; ?>
										</span>
									</a>
								</div>
							<?php endforeach; ?>
			
						</div>
					</div>
		
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php $__env->startSection('after_style'); ?>
	##parent-placeholder-3cea6eaff3d76a7695a57d7903025a2085e64bfb##
<?php $__env->stopSection(); ?>

<?php $__env->startSection('before_scripts'); ?>
	##parent-placeholder-094e37d5f5003ce853bb823b74f26393141d779d##
	<script>
		/* Carousel Parameters */
		var carouselItems = <?php echo e((isset($featured) and isset($featured->posts)) ? collect($featured->posts)->count() : 0); ?>;
		var carouselAutoplay = <?php echo e((isset($featuredOptions) && isset($featuredOptions['autoplay'])) ? $featuredOptions['autoplay'] : 'false'); ?>;
		var carouselAutoplayTimeout = <?php echo e((isset($featuredOptions) && isset($featuredOptions['autoplay_timeout'])) ? $featuredOptions['autoplay_timeout'] : 1500); ?>;
		var carouselLang = {
			'navText': {
				'prev': "<?php echo e(t('prev')); ?>",
				'next': "<?php echo e(t('next')); ?>"
			}
		};
	</script>
<?php $__env->stopSection(); ?><?php /**PATH /home/developer/public_html/resources/views/home/inc/featured.blade.php ENDPATH**/ ?>