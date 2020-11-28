<?php $__env->startSection('search'); ?>
	##parent-placeholder-3559d7accf00360971961ca18989adc0614089c0##
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.form', 'search.inc.form'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="main-container">
		
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.breadcrumbs', 'search.inc.breadcrumbs'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.categories', 'search.inc.categories'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php if (\App\Models\Advertising::where('slug', 'top')->count() > 0): ?>
			<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.top', 'layouts.inc.advertising.top'], ['paddingTopExists' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php
			$paddingTopExists = false;
		else:
			if (isset($paddingTopExists) and $paddingTopExists) {
				$paddingTopExists = false;
			}
		endif;
		?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		<div class="container">
			<div class="row">

				<!-- Sidebar -->
                <?php if(config('settings.listing.left_sidebar')): ?>
                    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.sidebar', 'search.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php $contentColSm = 'col-md-9'; ?>
                <?php else: ?>
                    <?php $contentColSm = 'col-md-12'; ?>
                <?php endif; ?>

				<!-- Content -->
				<div class="<?php echo e($contentColSm); ?> page-content col-thin-left">
					<div class="category-list<?php echo e(($contentColSm == 'col-md-12') ? ' noSideBar' : ''); ?>">
						<div class="tab-box">

							<!-- Nav tabs -->
							<ul id="postType" class="nav nav-tabs add-tabs tablist" role="tablist">
                                <?php
                                $liClass = 'class="nav-item"';
                                $spanClass = 'alert-danger';
                                if (!request()->filled('type') or request()->get('type') == '') {
                                    $liClass = 'class="nav-item active"';
                                    $spanClass = 'badge-danger';
                                }
                                ?>
								<li <?php echo $liClass; ?>>
									<a href="<?php echo qsUrl(request()->url(), request()->except(['page', 'type']), null, false); ?>" role="tab" data-toggle="tab" class="nav-link">
										<?php echo e(t('All Ads')); ?> <span class="badge badge-pill <?php echo $spanClass; ?>"><?php echo e($count->get('all')); ?></span>
									</a>
								</li>
                                <?php if(!empty($postTypes)): ?>
                                    <?php $__currentLoopData = $postTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $postTypeUrl = qsUrl(request()->url(), array_merge(request()->except(['page']), ['type' => $postType->tid]), null, false);
                                            $postTypeCount = ($count->has($postType->tid)) ? $count->get($postType->tid) : 0;
                                        ?>
                                        <?php if(request()->filled('type') && request()->get('type') == $postType->tid): ?>
                                            <li class="nav-item active">
                                                <a href="<?php echo $postTypeUrl; ?>" role="tab" data-toggle="tab" class="nav-link">
                                                    <?php echo e($postType->name); ?>

                                                    <span class="badge badge-pill badge-danger">
                                                        <?php echo e($postTypeCount); ?>

                                                    </span>
                                                </a>
                                            </li>
                                        <?php else: ?>
                                            <li class="nav-item">
                                                <a href="<?php echo $postTypeUrl; ?>" role="tab" data-toggle="tab" class="nav-link">
                                                    <?php echo e($postType->name); ?>

                                                    <span class="badge badge-pill alert-danger">
                                                        <?php echo e($postTypeCount); ?>

                                                    </span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
							</ul>
							
							<div class="tab-filter">
								<select id="orderBy" title="sort by" class="niceselecter select-sort-by" data-style="btn-select" data-width="auto">
									<option value="<?php echo qsUrl(request()->url(), request()->except(['orderBy', 'distance']), null, false); ?>"><?php echo e(t('Sort by')); ?></option>
									<option<?php echo e((request()->get('orderBy')=='priceAsc') ? ' selected="selected"' : ''); ?>

											value="<?php echo qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'priceAsc']), null, false); ?>">
										<?php echo e(t('price_low_to_high')); ?>

									</option>
									<option<?php echo e((request()->get('orderBy')=='priceDesc') ? ' selected="selected"' : ''); ?>

											value="<?php echo qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'priceDesc']), null, false); ?>">
										<?php echo e(t('price_high_to_low')); ?>

									</option>
									<option<?php echo e((request()->get('orderBy')=='relevance') ? ' selected="selected"' : ''); ?>

											value="<?php echo qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'relevance']), null, false); ?>">
										<?php echo e(t('Relevance')); ?>

									</option>
									<option<?php echo e((request()->get('orderBy')=='date') ? ' selected="selected"' : ''); ?>

											value="<?php echo qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'date']), null, false); ?>">
										<?php echo e(t('Date')); ?>

									</option>
									<?php if(isset($isCitySearch) and $isCitySearch and isset($distanceRange) and !empty($distanceRange)): ?>
										<?php $__currentLoopData = $distanceRange; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option<?php echo e((request()->get('distance', config('settings.listing.search_distance_default', 100))==$value) ? ' selected="selected"' : ''); ?>

													value="<?php echo qsUrl(request()->url(), array_merge(request()->except('distance'), ['distance' => $value]), null, false); ?>">
												<?php echo e(t('around_x_distance', ['distance' => $value, 'unit' => getDistanceUnit()])); ?>

											</option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
									<?php if(config('plugins.reviews.installed')): ?>
										<option<?php echo e((request()->get('orderBy')=='rating') ? ' selected="selected"' : ''); ?>

												value="<?php echo qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'rating']), null, false); ?>">
										<?php echo e(trans('reviews::messages.Rating')); ?>

										</option>
									<?php endif; ?>
								</select>
							</div>

						</div>

						<div class="listing-filter">
							<div class="pull-left col-xs-6">
								<div class="breadcrumb-list">
									<?php echo (isset($htmlTitle)) ? $htmlTitle : ''; ?>

								</div>
                                <div style="clear:both;"></div>
							</div>
                            
							<?php if($paginator->getCollection()->count() > 0): ?>
								<div class="pull-right col-xs-6 text-right listing-view-action">
									<span class="list-view"><i class="icon-th"></i></span>
									<span class="compact-view"><i class="icon-th-list"></i></span>
									<span class="grid-view active"><i class="icon-th-large"></i></span>
								</div>
							<?php endif; ?>

							<div style="clear:both"></div>
						</div>
						
						<!-- Mobile Filter Bar -->
						<div class="mobile-filter-bar col-xl-12">
							<ul class="list-unstyled list-inline no-margin no-padding">
								<?php if(config('settings.listing.left_sidebar')): ?>
								<li class="filter-toggle">
									<a class="">
										<i class="icon-th-list"></i> <?php echo e(t('Filters')); ?>

									</a>
								</li>
								<?php endif; ?>
								<li>
									<div class="dropdown">
										<a data-toggle="dropdown" class="dropdown-toggle"><?php echo e(t('Sort by')); ?></a>
										<ul class="dropdown-menu">
											<li>
												<a href="<?php echo qsUrl(request()->url(), request()->except(['orderBy', 'distance']), null, false); ?>" rel="nofollow">
													<?php echo e(t('Sort by')); ?>

												</a>
											</li>
											<li>
												<a href="<?php echo qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'priceAsc']), null, false); ?>" rel="nofollow">
													<?php echo e(t('price_low_to_high')); ?>

												</a>
											</li>
											<li>
												<a href="<?php echo qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'priceDesc']), null, false); ?>" rel="nofollow">
													<?php echo e(t('price_high_to_low')); ?>

												</a>
											</li>
											<li>
												<a href="<?php echo qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'relevance']), null, false); ?>" rel="nofollow">
													<?php echo e(t('Relevance')); ?>

												</a>
											</li>
											<li>
												<a href="<?php echo qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'date']), null, false); ?>" rel="nofollow">
													<?php echo e(t('Date')); ?>

												</a>
											</li>
											<?php if(isset($isCitySearch) and $isCitySearch and isset($distanceRange) and !empty($distanceRange)): ?>
												<?php $__currentLoopData = $distanceRange; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<li>
														<a href="<?php echo qsUrl(request()->url(), array_merge(request()->except('distance'), ['distance' => $value]), null, false); ?>" rel="nofollow">
															<?php echo e(t('around_x_distance', ['distance' => $value, 'unit' => getDistanceUnit()])); ?>

														</a>
													</li>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
											<?php if(config('plugins.reviews.installed')): ?>
												<li>
													<a href="<?php echo qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'rating']), null, false); ?>"
													   rel="nofollow">
														<?php echo e(trans('reviews::messages.Rating')); ?>

													</a>
												</li>
											<?php endif; ?>
										</ul>
									</div>
								</li>
							</ul>
						</div>
						<div class="menu-overly-mask"></div>
						<!-- Mobile Filter bar End-->

						<div id="postsList" class="adds-wrapper row no-margin">
							<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.posts', 'search.inc.posts'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						</div>

						<div class="tab-box save-search-bar text-center">
							<?php if(request()->filled('q') and request()->get('q') != '' and $count->get('all') > 0): ?>
								<a name="<?php echo qsUrl(request()->url(), request()->except(['_token', 'location']), null, false); ?>" id="saveSearch"
								   count="<?php echo e($count->get('all')); ?>">
									<i class="icon-star-empty"></i> <?php echo e(t('Save Search')); ?>

								</a>
							<?php else: ?>
								<a href="#"> &nbsp; </a>
							<?php endif; ?>
						</div>
					</div>
					
					<nav class="pagination-bar mb-5 pagination-sm" aria-label="">
						<?php echo $paginator->appends(request()->query())->render(); ?>

					</nav>

					<div class="post-promo text-center mb-5">
						<h2> <?php echo e(t('do_have_anything_to_sell_or_rent')); ?> </h2>
						<h5><?php echo e(t('sell_products_and_services_online_for_free')); ?></h5>
						<?php if(!auth()->check() and config('settings.single.guests_can_post_ads') != '1'): ?>
							<a href="#quickLogin" class="btn btn-border btn-post btn-add-listing" data-toggle="modal"><?php echo e(t('start_now')); ?></a>
						<?php else: ?>
							<a href="<?php echo e(\App\Helpers\UrlGen::addPost()); ?>" class="btn btn-border btn-post btn-add-listing"><?php echo e(t('start_now')); ?></a>
						<?php endif; ?>
					</div>

				</div>
				
				<div style="clear:both;"></div>

				<!-- Advertising -->
				<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.bottom', 'layouts.inc.advertising.bottom'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal_location'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.modal.location', 'layouts.inc.modal.location'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
		$(document).ready(function () {
			$('#postType a').click(function (e) {
				e.preventDefault();
				var goToUrl = $(this).attr('href');
				redirect(goToUrl);
			});
			$('#orderBy').change(function () {
				var goToUrl = $(this).val();
				redirect(goToUrl);
			});
		});
		
		<?php if(config('settings.optimization.lazy_loading_activation') == 1): ?>
		$(document).ready(function () {
			$('#postsList').each(function () {
				var $masonry = $(this);
				var update = function () {
					$.fn.matchHeight._update();
				};
				$('.item-list', $masonry).matchHeight();
				this.addEventListener('load', update, true);
			});
		});
		<?php endif; ?>
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/search/results.blade.php ENDPATH**/ ?>