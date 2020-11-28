<header class="topbar">
	<?php
	$navbarTheme = (config('settings.style.admin_navbar_bg') == 'skin6') ? 'navbar-light' : 'navbar-dark';
	?>
	<nav class="navbar top-navbar navbar-expand-md <?php echo e($navbarTheme); ?>">
		
		<div class="navbar-header">
			
			
			<a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
				<i class="ti-menu ti-close"></i>
			</a>
			
			
			<a class="navbar-brand" href="<?php echo e(url('/')); ?>" target="_blank">
				
				<span class="logo-text">
					<img src="<?php echo e(imgUrl(config('settings.app.logo_dark'), 'adminLogo')); ?>" alt="<?php echo e(strtolower(config('settings.app.app_name'))); ?>" class="dark-logo img-fluid"/>
					<img src="<?php echo e(imgUrl(config('settings.app.logo_light'), 'adminLogo')); ?>" alt="<?php echo e(strtolower(config('settings.app.app_name'))); ?>" class="light-logo img-fluid"/>
				</span>
			</a>
			
			
			<a class="topbartoggler d-block d-md-none waves-effect waves-light"
			   href="javascript:void(0)"
			   data-toggle="collapse"
			   data-target="#navbarSupportedContent"
			   aria-controls="navbarSupportedContent"
			   aria-expanded="false"
			   aria-label="Toggle navigation"
			>
				<i class="ti-more"></i>
			</a>
			
		</div>
		
		<div class="navbar-collapse collapse" id="navbarSupportedContent">
			
			<ul class="navbar-nav mr-auto float-left">
				<li class="nav-item">
					<a class="nav-link sidebartoggler d-none d-md-block waves-effect waves-dark" href="javascript:void(0)">
						<i class="ti-menu"></i>
					</a>
				</li>
			</ul>
			
			
			<ul class="navbar-nav float-right">
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle waves-effect waves-dark"
					   href=""
					   data-toggle="dropdown"
					   aria-haspopup="true"
					   aria-expanded="false"
					>
						<img src="<?php echo e(Gravatar::get(auth()->user()->email)); ?>"
							 alt="user"
							 width="30"
							 class="profile-pic rounded-circle"
						/>
					</a>
					<div class="dropdown-menu mailbox dropdown-menu-right">
						<ul class="dropdown-user list-style-none">
							<li>
								<div class="dw-user-box p-3 d-flex">
									<div class="u-img">
										<img src="<?php echo e(Gravatar::get(auth()->user()->email)); ?>"
											 alt="user"
											 class="rounded"
											 width="80"
										>
									</div>
									<div class="u-text ml-2">
										<h4 class="mb-0"><?php echo e(auth()->user()->name); ?></h4>
										<p class="text-muted mb-1 font-14"><?php echo e(auth()->user()->email); ?></p>
										<a href="<?php echo e(admin_url('account')); ?>" class="btn btn-rounded btn-danger btn-sm text-white d-inline-block">
											<?php echo e(trans('admin.my_account')); ?>

										</a>
									</div>
								</div>
							</li>
							<li role="separator" class="dropdown-divider"></li>
							<li class="user-list">
								<a class="px-3 py-2" href="<?php echo e(admin_url('account')); ?>">
									<i class="ti-settings"></i> <?php echo e(trans('admin.my_account')); ?>

								</a>
							</li>
							<li role="separator" class="dropdown-divider"></li>
							<li class="user-list">
								<a class="px-3 py-2" href="<?php echo e(admin_url('logout')); ?>">
									<i class="fa fa-power-off"></i> <?php echo e(trans('admin.logout')); ?>

								</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
		
	</nav>
</header>
<?php /**PATH /home/developer/public_html/resources/views/vendor/admin/layouts/inc/header.blade.php ENDPATH**/ ?>