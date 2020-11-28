<?php if(auth()->check()): ?>
	<?php
	// Get plugins admin menu
	$pluginsMenu = '';
	$plugins = plugin_installed_list();
	if (!empty($plugins)) {
		foreach($plugins as $plugin) {
			if (method_exists($plugin->class, 'getAdminMenu')) {
				$pluginsMenu .= call_user_func($plugin->class . '::getAdminMenu');
			}
		}
	}
	?>
	<style>
		#adminSidebar ul li span {
			text-transform: capitalize;
		}
	</style>
	<aside class="left-sidebar" id="adminSidebar">
		
		<div class="scroll-sidebar">
			
			<nav class="sidebar-nav">
				<ul id="sidebarnav">
					<li class="sidebar-item user-profile">
						<a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
							<img src="<?php echo e(Gravatar::get(auth()->user()->email)); ?>" alt="user">
							<span class="hide-menu"><?php echo e(auth()->user()->name); ?></span>
						</a>
						<ul aria-expanded="false" class="collapse first-level">
							<li class="sidebar-item">
								<a href="<?php echo e(admin_url('account')); ?>" class="sidebar-link p-0">
									<i class="mdi mdi-adjust"></i>
									<span class="hide-menu"><?php echo e(trans('admin.my_account')); ?></span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="<?php echo e(admin_url('logout')); ?>" class="sidebar-link p-0">
									<i class="mdi mdi-adjust"></i>
									<span class="hide-menu"><?php echo e(trans('admin.logout')); ?></span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="sidebar-item">
						<a href="<?php echo e(admin_url('dashboard')); ?>" class="sidebar-link waves-effect waves-dark">
							<i data-feather="home" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.dashboard')); ?></span>
						</a>
					</li>
					<?php if(
						auth()->user()->can('list-post') ||
						auth()->user()->can('list-category') ||
						auth()->user()->can('list-picture') ||
						auth()->user()->can('list-post-type') ||
						auth()->user()->can('list-field') ||
						userHasSuperAdminPermissions()
					): ?>
						<li class="sidebar-item">
							<a href="#" class="sidebar-link has-arrow waves-effect waves-dark">
								<i data-feather="list"></i> <span class="hide-menu"><?php echo e(trans('admin.ads')); ?></span>
							</a>
							<ul aria-expanded="false" class="collapse first-level">
								<?php if(auth()->user()->can('list-post') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('posts')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.list')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-category') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('categories')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.categories')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-picture') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('pictures')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.pictures')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-post-type') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('p_types')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.ad types')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-field') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('custom_fields')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.custom fields')); ?></span>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</li>
					<?php endif; ?>
					
					<?php if(
						auth()->user()->can('list-user') ||
						auth()->user()->can('list-role') ||
						auth()->user()->can('list-permission') ||
						auth()->user()->can('list-gender') ||
						userHasSuperAdminPermissions()
					): ?>
						<li  class="sidebar-item">
							<a href="#" class="sidebar-link has-arrow waves-effect waves-dark">
								<i data-feather="users" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.users')); ?></span>
							</a>
							<ul aria-expanded="false" class="collapse first-level">
								<?php if(auth()->user()->can('list-user') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('users')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.list')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-role') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('roles')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.roles')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-permission') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('permissions')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.permissions')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-gender') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('genders')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.titles')); ?></span>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</li>
					<?php endif; ?>
					
					<?php if(auth()->user()->can('list-payment') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(admin_url('payments')); ?>" class="sidebar-link">
								<i data-feather="dollar-sign" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.payments')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php if(auth()->user()->can('list-page') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(admin_url('pages')); ?>" class="sidebar-link">
								<i data-feather="book-open" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.pages')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php echo $pluginsMenu; ?>

					
					
					<?php if(
						auth()->user()->can('list-setting') ||
						auth()->user()->can('list-home-section') ||
						auth()->user()->can('list-language') ||
						auth()->user()->can('list-meta-tag') ||
						auth()->user()->can('list-package') ||
						auth()->user()->can('list-payment-method') ||
						auth()->user()->can('list-advertising') ||
						auth()->user()->can('list-country') ||
						auth()->user()->can('list-currency') ||
						auth()->user()->can('list-time-zone') ||
						auth()->user()->can('list-blacklist') ||
						auth()->user()->can('list-report-type') ||
						userHasSuperAdminPermissions()
					): ?>
						<li class="nav-small-cap">
							<i class="mdi mdi-dots-horizontal"></i>
							<span class="hide-menu"><?php echo e(trans('admin.configuration')); ?></span>
						</li>
						
						<li  class="sidebar-item">
							<a href="#" class="sidebar-link has-arrow waves-effect waves-dark">
								<i data-feather="settings" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.setup')); ?></span>
							</a>
							<ul aria-expanded="false" class="collapse first-level">
								<?php if(auth()->user()->can('list-setting') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('settings')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.general settings')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-home-section') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('homepage')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.homepage')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-language') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('languages')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.languages')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-meta-tag') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('meta_tags')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.meta tags')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-package') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('packages')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.packages')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-payment-method') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('payment_methods')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.payment methods')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-advertising') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('advertisings')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.advertising')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(
									auth()->user()->can('list-country') ||
									auth()->user()->can('list-currency') ||
									auth()->user()->can('list-time-zone') ||
									userHasSuperAdminPermissions()
								): ?>
									<li class="sidebar-item">
										<a href="#" class="has-arrow sidebar-link">
											<i class="fa fa-globe"></i> <span class="hide-menu"><?php echo e(trans('admin.international')); ?></span>
										</a>
										<ul aria-expanded="false" class="collapse second-level">
											<?php if(auth()->user()->can('list-country') || userHasSuperAdminPermissions()): ?>
												<li class="sidebar-item">
													<a href="<?php echo e(admin_url('countries')); ?>" class="sidebar-link">
														<i class="mdi mdi-adjust"></i>
														<span class="hide-menu"><?php echo e(trans('admin.countries')); ?></span>
													</a>
												</li>
											<?php endif; ?>
											<?php if(auth()->user()->can('list-currency') || userHasSuperAdminPermissions()): ?>
												<li class="sidebar-item">
													<a href="<?php echo e(admin_url('currencies')); ?>" class="sidebar-link">
														<i class="mdi mdi-adjust"></i>
														<span class="hide-menu"><?php echo e(trans('admin.currencies')); ?></span>
													</a>
												</li>
											<?php endif; ?>
											<?php if(auth()->user()->can('list-time-zone') || userHasSuperAdminPermissions()): ?>
												<li class="sidebar-item">
													<a href="<?php echo e(admin_url('time_zones')); ?>" class="sidebar-link">
														<i class="mdi mdi-adjust"></i>
														<span class="hide-menu"><?php echo e(trans('admin.time zones')); ?></span>
													</a>
												</li>
											<?php endif; ?>
										</ul>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-blacklist') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('blacklists')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.blacklist')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('list-report-type') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('report_types')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.report types')); ?></span>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</li>
					<?php endif; ?>
					
					<?php if(auth()->user()->can('list-plugin') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(admin_url('plugins')); ?>" class="sidebar-link">
								<i data-feather="package" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.plugins')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php if(auth()->user()->can('clear-cache') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(admin_url('actions/clear_cache')); ?>" class="sidebar-link">
								<i data-feather="refresh-cw" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.clear cache')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php if(auth()->user()->can('list-backup') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(admin_url('backups')); ?>" class="sidebar-link">
								<i data-feather="hard-drive" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.backups')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					
					<?php if(
						auth()->user()->can('maintenance-up') ||
						auth()->user()->can('maintenance-down') ||
						userHasSuperAdminPermissions()
					): ?>
						<?php if(app()->isDownForMaintenance()): ?>
							<?php if(auth()->user()->can('maintenance-up') || userHasSuperAdminPermissions()): ?>
								<li class="sidebar-item">
									<a href="<?php echo e(admin_url('actions/maintenance_up')); ?>"
									   data-toggle="tooltip"
									   title="<?php echo e(trans('admin.Leave Maintenance Mode')); ?>"
									   class="sidebar-link"
									>
										<i data-feather="globe" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.Live Mode')); ?></span>
									</a>
								</li>
							<?php endif; ?>
						<?php else: ?>
							<?php if(auth()->user()->can('maintenance-down') || userHasSuperAdminPermissions()): ?>
								<li class="sidebar-item">
									<a href="#"
									   data-toggle="modal"
									   data-target="#maintenanceMode"
									   title="<?php echo e(trans('admin.Put in Maintenance Mode')); ?>"
									   class="sidebar-link"
									>
										<i data-feather="alert-circle"></i> <span class="hide-menu"><?php echo e(trans('admin.Maintenance')); ?></span>
									</a>
								</li>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
					
				</ul>
			</nav>
			
		</div>
		
	</aside>
<?php endif; ?>
<?php /**PATH /home/developer/public_html/resources/views/vendor/admin/layouts/inc/sidebar.blade.php ENDPATH**/ ?>