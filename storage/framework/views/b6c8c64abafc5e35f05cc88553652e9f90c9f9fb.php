<?php
if (
	config('settings.other.ios_app_url') ||
	config('settings.other.android_app_url') ||
	config('settings.social_link.facebook_page_url') ||
	config('settings.social_link.twitter_url') ||
	config('settings.social_link.google_plus_url') ||
	config('settings.social_link.linkedin_url') ||
	config('settings.social_link.pinterest_url') ||
	config('settings.social_link.instagram_url')
) {
	$colClass1 = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
	$colClass2 = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
	$colClass3 = 'col-lg-2 col-md-2 col-sm-2 col-xs-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
} else {
	$colClass1 = 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
	$colClass2 = 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
	$colClass3 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
}
?>
<footer class="main-footer">
	<div class="footer-content">
		<div class="container">
			<div class="row">
				
				<?php if(!config('settings.footer.hide_links')): ?>
					<div class="<?php echo e($colClass1); ?>">
						<div class="footer-col">
							<h4 class="footer-title"><?php echo e(t('about_us')); ?></h4>
							<ul class="list-unstyled footer-nav">
								<?php if(isset($pages) and $pages->count() > 0): ?>
									<?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<li>
											<?php
												$linkTarget = '';
												if ($page->target_blank == 1) {
													$linkTarget = 'target="_blank"';
												}
											?>
											<?php if(!empty($page->external_link)): ?>
												<a href="<?php echo $page->external_link; ?>" rel="nofollow" <?php echo $linkTarget; ?>> <?php echo e($page->name); ?> </a>
											<?php else: ?>
												<a href="<?php echo e(\App\Helpers\UrlGen::page($page)); ?>" <?php echo $linkTarget; ?>> <?php echo e($page->name); ?> </a>
											<?php endif; ?>
										</li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</ul>
						</div>
					</div>
					
					<div class="<?php echo e($colClass2); ?>">
						<div class="footer-col">
							<h4 class="footer-title"><?php echo e(t('Contact and Sitemap')); ?></h4>
							<ul class="list-unstyled footer-nav">
								<li><a href="<?php echo e(lurl(trans('routes.contact'))); ?>"> <?php echo e(t('Contact')); ?> </a></li>
								<li><a href="<?php echo e(\App\Helpers\UrlGen::sitemap()); ?>"> <?php echo e(t('sitemap')); ?> </a></li>
								<?php if(\App\Models\Country::where('active', 1)->count() > 1): ?>
									<li><a href="<?php echo e(lurl(trans('routes.countries'))); ?>"> <?php echo e(t('countries')); ?> </a></li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
					
					<div class="<?php echo e($colClass3); ?>">
						<div class="footer-col">
							<h4 class="footer-title"><?php echo e(t('My Account')); ?></h4>
							<ul class="list-unstyled footer-nav">
								<?php if(!auth()->user()): ?>
									<li>
										<?php if(config('settings.security.login_open_in_modal')): ?>
											<a href="#quickLogin" data-toggle="modal"> <?php echo e(t('log_in')); ?> </a>
										<?php else: ?>
											<a href="<?php echo e(lurl(trans('routes.login'))); ?>"> <?php echo e(t('log_in')); ?> </a>
										<?php endif; ?>
									</li>
									<li><a href="<?php echo e(lurl(trans('routes.register'))); ?>"> <?php echo e(t('register')); ?> </a></li>
								<?php else: ?>
									<li><a href="<?php echo e(lurl('account')); ?>"> <?php echo e(t('Personal Home')); ?> </a></li>
									<li><a href="<?php echo e(lurl('account/my-posts')); ?>"> <?php echo e(t('my_ads')); ?> </a></li>
									<li><a href="<?php echo e(lurl('account/favourite')); ?>"> <?php echo e(t('favourite_ads')); ?> </a></li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
					
					<?php if(
						config('settings.other.ios_app_url') or
						config('settings.other.android_app_url') or
						config('settings.social_link.facebook_page_url') or
						config('settings.social_link.twitter_url') or
						config('settings.social_link.google_plus_url') or
						config('settings.social_link.linkedin_url') or
						config('settings.social_link.pinterest_url') or
						config('settings.social_link.instagram_url')
						): ?>
						<div class="<?php echo e($colClass4); ?>">
							<div class="footer-col row">
								<?php
									$footerSocialClass = '';
									$footerSocialTitleClass = '';
								?>
								
								<?php if(config('settings.other.ios_app_url') or config('settings.other.android_app_url')): ?>
									<div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
										<div class="mobile-app-content">
											<h4 class="footer-title"><?php echo e(t('Mobile Apps')); ?></h4>
											<div class="row ">
												<?php if(config('settings.other.ios_app_url')): ?>
												<div class="col-xs-12 col-sm-6">
													<a class="app-icon" target="_blank" href="<?php echo e(config('settings.other.ios_app_url')); ?>">
														<span class="hide-visually"><?php echo e(t('iOS app')); ?></span>
														<img src="<?php echo e(url('images/site/app-store-badge.svg')); ?>" alt="<?php echo e(t('Available on the App Store')); ?>">
													</a>
												</div>
												<?php endif; ?>
												<?php if(config('settings.other.android_app_url')): ?>
												<div class="col-xs-12 col-sm-6">
													<a class="app-icon" target="_blank" href="<?php echo e(config('settings.other.android_app_url')); ?>">
														<span class="hide-visually"><?php echo e(t('Android App')); ?></span>
														<img src="<?php echo e(url('images/site/google-play-badge.svg')); ?>" alt="<?php echo e(t('Available on Google Play')); ?>">
													</a>
												</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
									<?php
										$footerSocialClass = 'hero-subscribe';
										$footerSocialTitleClass = 'no-margin';
									?>
								<?php endif; ?>
								
								<?php if(
									config('settings.social_link.facebook_page_url') or
									config('settings.social_link.twitter_url') or
									config('settings.social_link.google_plus_url') or
									config('settings.social_link.linkedin_url') or
									config('settings.social_link.pinterest_url') or
									config('settings.social_link.instagram_url')
									): ?>
									<div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
										<div class="<?php echo $footerSocialClass; ?>">
											<h4 class="footer-title <?php echo $footerSocialTitleClass; ?>"><?php echo e(t('Follow us on')); ?></h4>
											<ul class="list-unstyled list-inline footer-nav social-list-footer social-list-color footer-nav-inline">
												<?php if(config('settings.social_link.facebook_page_url')): ?>
												<li>
													<a class="icon-color fb" title="" data-placement="top" data-toggle="tooltip" href="<?php echo e(config('settings.social_link.facebook_page_url')); ?>" data-original-title="Facebook">
														<i class="fab fa-facebook"></i>
													</a>
												</li>
												<?php endif; ?>
												<?php if(config('settings.social_link.twitter_url')): ?>
												<li>
													<a class="icon-color tw" title="" data-placement="top" data-toggle="tooltip" href="<?php echo e(config('settings.social_link.twitter_url')); ?>" data-original-title="Twitter">
														<i class="fab fa-twitter"></i>
													</a>
												</li>
												<?php endif; ?>
												<?php if(config('settings.social_link.instagram_url')): ?>
													<li>
														<a class="icon-color pin" title="" data-placement="top" data-toggle="tooltip" href="<?php echo e(config('settings.social_link.instagram_url')); ?>" data-original-title="Instagram">
															<i class="icon-instagram-filled"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if(config('settings.social_link.google_plus_url')): ?>
												<li>
													<a class="icon-color gp" title="" data-placement="top" data-toggle="tooltip" href="<?php echo e(config('settings.social_link.google_plus_url')); ?>" data-original-title="Google+">
														<i class="fab fa-google-plus"></i>
													</a>
												</li>
												<?php endif; ?>
												<?php if(config('settings.social_link.linkedin_url')): ?>
												<li>
													<a class="icon-color lin" title="" data-placement="top" data-toggle="tooltip" href="<?php echo e(config('settings.social_link.linkedin_url')); ?>" data-original-title="LinkedIn">
														<i class="fab fa-linkedin"></i>
													</a>
												</li>
												<?php endif; ?>
												<?php if(config('settings.social_link.pinterest_url')): ?>
												<li>
													<a class="icon-color pin" title="" data-placement="top" data-toggle="tooltip" href="<?php echo e(config('settings.social_link.pinterest_url')); ?>" data-original-title="Pinterest">
														<i class="fab fa-pinterest-p"></i>
													</a>
												</li>
												<?php endif; ?>
											</ul>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
					
					<div style="clear: both"></div>
				<?php endif; ?>
				
				<div class="col-xl-12">
					<?php if(!config('settings.footer.hide_payment_plugins_logos') and isset($paymentMethods) and $paymentMethods->count() > 0): ?>
						<div class="text-center paymanet-method-logo">
							
							<?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if(file_exists(plugin_path($paymentMethod->name, 'public/images/payment.png'))): ?>
									<img src="<?php echo e(url('images/' . $paymentMethod->name . '/payment.png')); ?>" alt="<?php echo e($paymentMethod->display_name); ?>" title="<?php echo e($paymentMethod->display_name); ?>">
								<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					<?php else: ?>
						<?php if(!config('settings.footer.hide_links')): ?>
							<hr>
						<?php endif; ?>
					<?php endif; ?>
					
					<div class="copy-info text-center">
						© <?php echo e(date('Y')); ?> <?php echo e(config('settings.app.app_name')); ?>. <?php echo e(t('all_rights_reserved')); ?>.
						<?php if(!config('settings.footer.hide_powered_by')): ?>
							<?php if(config('settings.footer.powered_by_info')): ?>
								<?php echo e(t('Powered by')); ?> <?php echo config('settings.footer.powered_by_info'); ?>

							<?php else: ?>
								<?php echo e(t('Powered by')); ?> <a href="http://www.bedigit.com" title="BedigitCom">Bedigit</a>.
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			
			</div>
		</div>
	</div>
</footer>
<?php /**PATH /home/developer/public_html/resources/views/layouts/inc/footer.blade.php ENDPATH**/ ?>