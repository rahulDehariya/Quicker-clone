<?php
// Search parameters
$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';

// Logo Label
$logoLabel = '';
if (getSegment(1) != trans('routes.countries')) {
	if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled) {
		$logoLabel = config('settings.app.app_name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
	}
}
?>
<div class="header">
	<nav class="navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
        <div class="container">
			
			<div class="navbar-identity">
				
				<a href="<?php echo e(url(config('app.locale') . '/')); ?>" class="navbar-brand logo logo-title">
					<img src="<?php echo e(imgUrl(config('settings.app.logo', config('larapen.core.logo')), 'logo')); ?>" class="tooltipHere main-logo" />
				</a>
				
				<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggler pull-right" type="button">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30" focusable="false">
						<title><?php echo e(t('Menu')); ?></title>
						<path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"></path>
					</svg>
				</button>
				
				<?php if(getSegment(1) != trans('routes.countries')): ?>
					<?php if(isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled): ?>
						<?php if(!empty(config('country.icode'))): ?>
							<?php if(file_exists(public_path() . '/images/flags/24/' . config('country.icode') . '.png')): ?>
								<button class="flag-menu country-flag d-block d-md-none btn btn-secondary hidden pull-right" href="#selectCountry" data-toggle="modal">
									<img src="<?php echo e(url('images/flags/24/'.config('country.icode').'.png') . getPictureVersion()); ?>"
										 alt="<?php echo e(config('country.name')); ?>"
										 style="float: left;"
									>
									<span class="caret hidden-xs"></span>
								</button>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
            </div>
	
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left">
					
					<?php if(getSegment(1) != trans('routes.countries')): ?>
						<?php if(config('settings.geo_location.country_flag_activation')): ?>
							<?php if(!empty(config('country.icode'))): ?>
								<?php if(file_exists(public_path() . '/images/flags/32/' . config('country.icode') . '.png')): ?>
									<li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip" data-placement="<?php echo e((config('lang.direction') == 'rtl') ? 'bottom' : 'right'); ?>">
										<?php if(isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled): ?>
											<a href="#selectCountry" data-toggle="modal" class="nav-link">
												<img class="flag-icon"
													 src="<?php echo e(url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion()); ?>"
													 alt="<?php echo e(config('country.name')); ?>"
												>
												<span class="caret hidden-sm"></span>
											</a>
										<?php else: ?>
											<a style="cursor: default;">
												<img class="flag-icon no-caret"
													 src="<?php echo e(url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion()); ?>"
													 alt="<?php echo e(config('country.name')); ?>"
												>
											</a>
										<?php endif; ?>
									</li>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				</ul>
				
				<ul class="nav navbar-nav ml-auto navbar-right">
                    <?php if(!auth()->check()): ?>
                        <li class="nav-item">
							<a href="<?php echo e(url(config('app.locale') . '/' . trans('routes.login'))); ?>" class="nav-link">
								<i class="icon-user fa"></i> <?php echo e(t('log_in')); ?>

							</a>
						</li>
                        <li class="nav-item">
							<a href="<?php echo e(url(config('app.locale') . '/' . trans('routes.register'))); ?>" class="nav-link">
								<i class="icon-user-add fa"></i> <?php echo e(t('register')); ?>

							</a>
						</li>
                    <?php else: ?>
                        <li class="nav-item">
							<?php if(app('impersonate')->isImpersonating()): ?>
								<a href="<?php echo e(route('impersonate.leave')); ?>" class="nav-link">
									<i class="icon-logout hidden-sm"></i> <?php echo e(t('Leave')); ?>

								</a>
							<?php else: ?>
								<a href="<?php echo e(url(config('app.locale') . '/logout')); ?>" class="nav-link">
									<i class="glyphicon glyphicon-off"></i> <?php echo e(t('log_out')); ?>

								</a>
							<?php endif; ?>
						</li>
						<li class="nav-item dropdown no-arrow">
							<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<i class="icon-user fa hidden-sm"></i>
                                <span><?php echo e(auth()->user()->name); ?></span>
								<i class="icon-down-open-big fa hidden-sm"></i>
                            </a>
							<ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">
                                <li class="dropdown-item active">
                                    <a href="<?php echo e(url(config('app.locale') . '/account')); ?>">
                                        <i class="icon-home"></i> <?php echo e(t('Personal Home')); ?>

                                    </a>
                                </li>
                                <li class="dropdown-item">
									<a href="<?php echo e(url(config('app.locale') . '/account/my-posts')); ?>">
										<i class="icon-th-thumb"></i> <?php echo e(t('my_ads')); ?>

									</a>
								</li>
                                <li class="dropdown-item">
									<a href="<?php echo e(url(config('app.locale') . '/account/favourite')); ?>">
										<i class="icon-heart"></i> <?php echo e(t('favourite_ads')); ?>

									</a>
								</li>
                                <li class="dropdown-item">
									<a href="<?php echo e(url(config('app.locale') . '/account/saved-search')); ?>">
										<i class="icon-star-circled"></i> <?php echo e(t('Saved searches')); ?>

									</a>
								</li>
                                <li class="dropdown-item">
									<a href="<?php echo e(url(config('app.locale') . '/account/pending-approval')); ?>">
										<i class="icon-hourglass"></i> <?php echo e(t('pending_approval')); ?>

									</a>
								</li>
                                <li class="dropdown-item">
									<a href="<?php echo e(url(config('app.locale') . '/account/archived')); ?>">
										<i class="icon-folder-close"></i> <?php echo e(t('archived_ads')); ?>

									</a>
								</li>
                                <li class="dropdown-item">
									<a href="<?php echo e(url(config('app.locale') . '/account/conversations')); ?>">
										<i class="icon-mail-1"></i> <?php echo e(t('Conversations')); ?>

									</a>
								</li>
                                <li class="dropdown-item">
									<a href="<?php echo e(url(config('app.locale') . '/account/transactions')); ?>">
										<i class="icon-money"></i> <?php echo e(t('Transactions')); ?>

									</a>
								</li>
                            </ul>
                        </li>
                    <?php endif; ?>
	
					<li class="nav-item postadd">
						<?php if(!auth()->check()): ?>
							<?php if(config('settings.single.guests_can_post_ads') != '1'): ?>
								<a class="btn btn-block btn-border btn-post btn-add-listing" href="#quickLogin" data-toggle="modal">
									<i class="fa fa-plus-circle"></i> <?php echo e(t('Add Listing')); ?>

								</a>
							<?php else: ?>
								<a class="btn btn-block btn-border btn-post btn-add-listing" href="<?php echo e(\App\Helpers\UrlGen::addPost(true)); ?>">
									<i class="fa fa-plus-circle"></i> <?php echo e(t('Add Listing')); ?>

								</a>
							<?php endif; ?>
						<?php else: ?>
							<a class="btn btn-block btn-border btn-post btn-add-listing" href="<?php echo e(\App\Helpers\UrlGen::addPost(true)); ?>">
								<i class="fa fa-plus-circle"></i> <?php echo e(t('Add Listing')); ?>

							</a>
						<?php endif; ?>
					</li>

                    <?php if(!empty(config('lang.abbr'))): ?>
                        <?php if(is_array(LaravelLocalization::getSupportedLocales()) && count(LaravelLocalization::getSupportedLocales()) > 1): ?>
                            <!-- Language selector -->
							<li class="dropdown lang-menu nav-item">
								<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
									<span class="lang-title"><?php echo e(strtoupper(config('app.locale'))); ?></span>
                                </button>
								<ul id="langMenuDropdown" class="dropdown-menu dropdown-menu-right user-menu shadow-sm" role="menu">
                                    <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(strtolower($localeCode) != strtolower(config('app.locale'))): ?>
											<?php
												// Controller Parameters
												$attr = [];
												$attr['countryCode'] = config('country.icode');
												if (isset($uriPathCatSlug)) {
													$attr['catSlug'] = $uriPathCatSlug;
													if (isset($uriPathSubCatSlug)) {
														$attr['subCatSlug'] = $uriPathSubCatSlug;
													}
												}
												if (isset($uriPathCityName) && isset($uriPathCityId)) {
													$attr['city'] = $uriPathCityName;
													$attr['id'] = $uriPathCityId;
												}
												if (isset($uriPathUserId)) {
													$attr['id'] = $uriPathUserId;
													if (isset($uriPathUsername)) {
														$attr['username'] = $uriPathUsername;
													}
												}
												if (isset($uriPathUsername)) {
													if (isset($uriPathUserId)) {
														$attr['id'] = $uriPathUserId;
													}
													$attr['username'] = $uriPathUsername;
												}
												if (isset($uriPathTag)) {
													$attr['tag'] = $uriPathTag;
												}
												if (isset($uriPathPageSlug)) {
													$attr['slug'] = $uriPathPageSlug;
												}
				
												// Default
												// $link = LaravelLocalization::getLocalizedURL($localeCode, null, $attr);
												$link = lurl(null, $attr, $localeCode);
												$localeCode = strtolower($localeCode);
											?>
											<li class="dropdown-item">
                                                <a href="<?php echo e($link); ?>" tabindex="-1" rel="alternate" hreflang="<?php echo e($localeCode); ?>">
													<span class="lang-name"><?php echo e($properties['native']); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</div><?php /**PATH /home/developer/public_html/resources/views/errors/layouts/inc/header.blade.php ENDPATH**/ ?>