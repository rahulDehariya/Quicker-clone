<?php
// Search parameters
$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');

// Get the Default Language
$cacheExpiration = (isset($cacheExpiration)) ? $cacheExpiration : config('settings.optimization.cache_expiration', 86400);
$defaultLang = Cache::remember('language.default', $cacheExpiration, function () {
    $defaultLang = \App\Models\Language::where('default', 1)->first();
    return $defaultLang;
});

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';
if (config('settings.geo_location.country_flag_activation')) {
	if (!empty(config('country.code'))) {
		if (\App\Models\Country::where('active', 1)->count() > 1) {
			$multiCountriesIsEnabled = true;
			$multiCountriesLabel = 'title="' . t('Select a Country') . '"';
		}
	}
}

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
				
				<a href="<?php echo e(lurl('/')); ?>" class="navbar-brand logo logo-title">
					<img src="<?php echo e(imgUrl(config('settings.app.logo'), 'logo')); ?>"
						 alt="<?php echo e(strtolower(config('settings.app.app_name'))); ?>" class="tooltipHere main-logo" title="" data-placement="bottom"
						 data-toggle="tooltip"
						 data-original-title="<?php echo isset($logoLabel) ? $logoLabel : ''; ?>"/>
				</a>
				
				<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggler pull-right" type="button">
					<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30" focusable="false">
						<title><?php echo e(t('Menu')); ?></title>
						<path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"></path>
					</svg>
				</button>
				
				<?php if(getSegment(1) != trans('routes.countries')): ?>
					<?php if(isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled): ?>
						<?php if(!empty(config('country.icode'))): ?>
							<?php if(file_exists(public_path() . '/images/flags/24/' . config('country.icode') . '.png')): ?>
								<button class="flag-menu country-flag d-block d-md-none btn btn-secondary hidden pull-right" href="#selectCountry" data-toggle="modal">
									<img src="<?php echo e(url('images/flags/24/' . config('country.icode') . '.png') . getPictureVersion()); ?>"
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
									<li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip" data-placement="<?php echo e((config('lang.direction') == 'rtl') ? 'bottom' : 'right'); ?>" <?php echo $multiCountriesLabel; ?>>
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
							<?php if(config('settings.security.login_open_in_modal')): ?>
								<a href="#quickLogin" class="nav-link" data-toggle="modal"><i class="icon-user fa"></i> <?php echo e(t('log_in')); ?></a>
							<?php else: ?>
								<a href="<?php echo e(lurl(trans('routes.login'))); ?>" class="nav-link"><i class="icon-user fa"></i> <?php echo e(t('log_in')); ?></a>
							<?php endif; ?>
						</li>
						<li class="nav-item hidden-sm">
							<a href="<?php echo e(lurl(trans('routes.register'))); ?>" class="nav-link"><i class="icon-user-add fa"></i> <?php echo e(t('register')); ?></a>
						</li>
					<?php else: ?>
						<li class="nav-item hidden-sm">
							<?php if(app('impersonate')->isImpersonating()): ?>
								<a href="<?php echo e(route('impersonate.leave')); ?>" class="nav-link">
									<i class="icon-logout hidden-sm"></i> <?php echo e(t('Leave')); ?>

								</a>
							<?php else: ?>
								<a href="<?php echo e(lurl(trans('routes.logout'))); ?>" class="nav-link">
									<i class="icon-logout hidden-sm"></i> <?php echo e(t('log_out')); ?>

								</a>
							<?php endif; ?>
						</li>
						<li class="nav-item dropdown no-arrow">
							<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<i class="icon-user fa hidden-sm"></i>
								<span><?php echo e(auth()->user()->name); ?></span>
								<span class="badge badge-pill badge-important count-conversations-with-new-messages hidden-sm">0</span>
								<i class="icon-down-open-big fa hidden-sm"></i>
							</a>
							<ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">
								<li class="dropdown-item active">
									<a href="<?php echo e(lurl('account')); ?>">
										<i class="icon-home"></i> <?php echo e(t('Personal Home')); ?>

									</a>
								</li>
								<li class="dropdown-item"><a href="<?php echo e(lurl('account/my-posts')); ?>"><i class="icon-th-thumb"></i> <?php echo e(t('my_ads')); ?> </a></li>
								<li class="dropdown-item"><a href="<?php echo e(lurl('account/favourite')); ?>"><i class="icon-heart"></i> <?php echo e(t('favourite_ads')); ?> </a></li>
								<li class="dropdown-item"><a href="<?php echo e(lurl('account/saved-search')); ?>"><i class="icon-star-circled"></i> <?php echo e(t('Saved searches')); ?> </a></li>
								<li class="dropdown-item"><a href="<?php echo e(lurl('account/pending-approval')); ?>"><i class="icon-hourglass"></i> <?php echo e(t('pending_approval')); ?> </a></li>
								<li class="dropdown-item"><a href="<?php echo e(lurl('account/archived')); ?>"><i class="icon-folder-close"></i> <?php echo e(t('archived_ads')); ?></a></li>
								<li class="dropdown-item">
									<a href="<?php echo e(lurl('account/conversations')); ?>">
										<i class="icon-mail-1"></i> <?php echo e(t('Conversations')); ?>

										<span class="badge badge-pill badge-important count-conversations-with-new-messages">0</span>
									</a>
								</li>
								<li class="dropdown-item"><a href="<?php echo e(lurl('account/transactions')); ?>"><i class="icon-money"></i> <?php echo e(t('Transactions')); ?></a></li>
								<li class="dropdown-divider"></li>
								<li class="dropdown-item">
									<?php if(app('impersonate')->isImpersonating()): ?>
										<a href="<?php echo e(route('impersonate.leave')); ?>"><i class="icon-logout"></i> <?php echo e(t('Leave')); ?></a>
									<?php else: ?>
										<a href="<?php echo e(lurl(trans('routes.logout'))); ?>"><i class="icon-logout"></i> <?php echo e(t('log_out')); ?></a>
									<?php endif; ?>
								</li>
							</ul>
						</li>
					<?php endif; ?>
					
					<?php if(config('plugins.currencyexchange.installed')): ?>
						<?php echo $__env->make('currencyexchange::select-currency', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<?php endif; ?>
					
					<?php if(config('settings.single.pricing_page_enabled') == '2'): ?>
						<li class="nav-item pricing">
							<a href="<?php echo e(lurl(trans('routes.pricing'))); ?>" class="nav-link">
								<i class="fas fa-tags"></i> <?php echo e(t('pricing_label')); ?>

							</a>
						</li>
					<?php endif; ?>
					
					<?php
						$addListingUrl = \App\Helpers\UrlGen::addPost();
						$addListingAttr = '';
						if (!auth()->check()) {
							if (config('settings.single.guests_can_post_ads') != '1') {
								$addListingUrl = '#quickLogin';
								$addListingAttr = ' data-toggle="modal"';
							}
						}
						if (config('settings.single.pricing_page_enabled') == '1') {
							$addListingUrl = lurl(trans('routes.pricing'));
							$addListingAttr = '';
						}
					?>
					<li class="nav-item postadd">
						<a class="btn btn-block btn-border btn-post btn-add-listing" href="<?php echo e($addListingUrl); ?>"<?php echo $addListingAttr; ?>>
							<i class="fa fa-plus-circle"></i> <?php echo e(t('Add Listing')); ?>

						</a>
					</li>
					
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.menu.select-language', 'layouts.inc.menu.select-language'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					
				</ul>
			</div>
			
			
		</div>
	</nav>
</div><?php /**PATH /home/developer/public_html/resources/views/layouts/inc/header.blade.php ENDPATH**/ ?>