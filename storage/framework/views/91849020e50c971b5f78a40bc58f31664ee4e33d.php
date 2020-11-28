<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">

				<?php if(Session::has('flash_notification')): ?>
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="col-md-3 page-sidebar">
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
				<!--/.page-sidebar-->

				<div class="col-md-9 page-content">
					<div class="inner-box">
						<?php if($pagePath=='my-posts'): ?>
							<h2 class="title-2"><i class="icon-docs"></i> <?php echo e(t('my_ads')); ?> </h2>
						<?php elseif($pagePath=='archived'): ?>
							<h2 class="title-2"><i class="icon-folder-close"></i> <?php echo e(t('archived_ads')); ?> </h2>
						<?php elseif($pagePath=='favourite'): ?>
							<h2 class="title-2"><i class="icon-heart-1"></i> <?php echo e(t('favourite_ads')); ?> </h2>
						<?php elseif($pagePath=='pending-approval'): ?>
							<h2 class="title-2"><i class="icon-hourglass"></i> <?php echo e(t('pending_approval')); ?> </h2>
						<?php else: ?>
							<h2 class="title-2"><i class="icon-docs"></i> <?php echo e(t('posts')); ?> </h2>
						<?php endif; ?>

						<div class="table-responsive">
							<form name="listForm" method="POST" action="<?php echo e(lurl('account/'.$pagePath.'/delete')); ?>">
								<?php echo csrf_field(); ?>

								<div class="table-action">
									<label for="checkAll">
										<input type="checkbox" id="checkAll">
										<?php echo e(t('Select')); ?>: <?php echo e(t('All')); ?> |
										<button type="submit" class="btn btn-sm btn-default delete-action">
											<i class="fa fa-trash"></i> <?php echo e(t('Delete')); ?>

										</button>
									</label>
									<div class="table-search pull-right col-sm-7">
										<div class="form-group">
											<div class="row">
												<label class="col-sm-5 control-label text-right"><?php echo e(t('search')); ?> <br>
													<a title="clear filter" class="clear-filter" href="#clear">[<?php echo e(t('clear')); ?>]</a>
												</label>
												<div class="col-sm-7 searchpan">
													<input type="text" class="form-control" id="filter">
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<table id="addManageTable" class="table table-striped table-bordered add-manage-table table demo" data-filter="#filter" data-filter-text-only="true">
									<thead>
									<tr>
										<th data-type="numeric" data-sort-initial="true"></th>
										<th><?php echo e(t('Photo')); ?></th>
										<th data-sort-ignore="true"><?php echo e(t('Ads Details')); ?></th>
										<th data-type="numeric">--</th>
										<th><?php echo e(t('Option')); ?></th>
									</tr>
									</thead>
									<tbody>

									<?php
									if (isset($posts) && $posts->count() > 0):
									foreach($posts as $key => $post):
										// Fixed 1
										if ($pagePath == 'favourite') {
											if (isset($post->post)) {
												if (!empty($post->post)) {
													$post = $post->post;
												} else {
													continue;
												}
											} else {
												continue;
											}
										}

										// Fixed 2
										if (!$countries->has($post->country_code)) continue;

										// Get Post's URL
										$postUrl = \App\Helpers\UrlGen::post($post);
                                    
                                    	// Get Post's Pictures
                                        if ($post->pictures->count() > 0) {
                                            $postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
                                        } else {
                                            $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
                                        }

                                    	// Get country flag
                                    	$countryFlagPath = 'images/flags/16/' . strtolower($post->country_code) . '.png';
									?>
									<tr>
										<td style="width:2%" class="add-img-selector">
											<div class="checkbox">
												<label><input type="checkbox" name="entries[]" value="<?php echo e($post->id); ?>"></label>
											</div>
										</td>
										<td style="width:14%" class="add-img-td">
											<a href="<?php echo e($postUrl); ?>"><img class="img-thumbnail img-fluid" src="<?php echo e($postImg); ?>" alt="img"></a>
										</td>
										<td style="width:58%" class="items-details-td">
											<div>
												<p>
													<strong>
                                                        <a href="<?php echo e($postUrl); ?>" title="<?php echo e($post->title); ?>"><?php echo e(\Illuminate\Support\Str::limit($post->title, 40)); ?></a>
                                                    </strong>
													<?php if(in_array($pagePath, ['my-posts', 'archived', 'pending-approval'])): ?>
														<?php if(isset($post->latestPayment) and !empty($post->latestPayment)): ?>
															<?php if(isset($post->latestPayment->package) and !empty($post->latestPayment->package)): ?>
																<?php
																if ($post->featured == 1) {
																	$color = $post->latestPayment->package->ribbon;
																	$packageInfo = '';
																} else {
																	$color = '#ddd';
																	$packageInfo = ' (' . t('Expired') . ')';
																}
																?>
																<i class="fa fa-check-circle tooltipHere" style="color: <?php echo e($color); ?>;" title="" data-placement="bottom"
																   data-toggle="tooltip" data-original-title="<?php echo e($post->latestPayment->package->short_name . $packageInfo); ?>"></i>
															<?php endif; ?>
														<?php endif; ?>
													<?php endif; ?>
                                                </p>
												<p>
													<strong><i class="icon-clock" title="<?php echo e(t('Posted On')); ?>"></i></strong>&nbsp;
													<?php echo e($post->created_at->formatLocalized(config('settings.app.default_datetime_format'))); ?>

												</p>
												<p>
													<strong><i class="icon-eye" title="<?php echo e(t('Visitors')); ?>"></i></strong> <?php echo e($post->visits ?? 0); ?>

													<strong><i class="icon-location-2" title="<?php echo e(t('Located In')); ?>"></i></strong> <?php echo e(!empty($post->city) ? $post->city->name : '-'); ?>

													<?php if(file_exists(public_path($countryFlagPath))): ?>
														<img src="<?php echo e(url($countryFlagPath)); ?>" data-toggle="tooltip" title="<?php echo e($post->country->name); ?>">
													<?php endif; ?>
												</p>
											</div>
										</td>
										<td style="width:16%" class="price-td">
											<div>
												<strong>
													<?php if($post->price > 0): ?>
														<?php echo \App\Helpers\Number::money($post->price); ?>

													<?php else: ?>
														<?php echo \App\Helpers\Number::money(' --'); ?>

													<?php endif; ?>
												</strong>
											</div>
										</td>
										<td style="width:10%" class="action-td">
											<div>
												<?php if(in_array($pagePath, ['my-posts']) and $post->user_id==$user->id and $post->archived==0): ?>
													<p>
                                                        <a class="btn btn-primary btn-sm" href="<?php echo e(\App\Helpers\UrlGen::editPost($post)); ?>">
                                                            <i class="fa fa-edit"></i> <?php echo e(t('Edit')); ?>

                                                        </a>
                                                    </p>
												<?php endif; ?>
												<?php if(in_array($pagePath, ['my-posts']) and isVerifiedPost($post) and $post->archived==0): ?>
													<p>
														<a class="btn btn-warning btn-sm confirm-action" href="<?php echo e(lurl('account/'.$pagePath.'/'.$post->id.'/offline')); ?>">
															<i class="icon-eye-off"></i> <?php echo e(t('Offline')); ?>

														</a>
													</p>
												<?php endif; ?>
												<?php if(in_array($pagePath, ['archived']) and $post->user_id==$user->id and $post->archived==1): ?>
													<p>
                                                        <a class="btn btn-info btn-sm confirm-action" href="<?php echo e(lurl('account/'.$pagePath.'/'.$post->id.'/repost')); ?>">
                                                            <i class="fa fa-recycle"></i> <?php echo e(t('Repost')); ?>

                                                        </a>
                                                    </p>
												<?php endif; ?>
												<p>
                                                    <a class="btn btn-danger btn-sm delete-action" href="<?php echo e(lurl('account/'.$pagePath.'/'.$post->id.'/delete')); ?>">
                                                        <i class="fa fa-trash"></i> <?php echo e(t('Delete')); ?>

                                                    </a>
                                                </p>
											</div>
										</td>
									</tr>
									<?php endforeach; ?>
                                    <?php endif; ?>
									</tbody>
								</table>
							</form>
						</div>
                            
                        <nav>
                            <?php echo e((isset($posts)) ? $posts->links() : ''); ?>

                        </nav>

					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
	<style>
		.action-td p {
			margin-bottom: 5px;
		}
	</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script src="<?php echo e(url('assets/js/footable.js?v=2-0-1')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/js/footable.filter.js?v=2-0-1')); ?>" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				var selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});

			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});

			$('#checkAll').click(function () {
				checkAll(this);
			});
			
			$('a.delete-action, button.delete-action, a.confirm-action').click(function(e)
			{
				e.preventDefault(); /* prevents the submit or reload */
				var confirmation = confirm("<?php echo e(t('confirm_this_action')); ?>");
				
				if (confirmation) {
					if( $(this).is('a') ){
						var url = $(this).attr('href');
						if (url !== 'undefined') {
							redirect(url);
						}
					} else {
						$('form[name=listForm]').submit();
					}
					
				}
				
				return false;
			});
		});
	</script>
	<!-- include custom script for ads table [select all checkbox]  -->
	<script>
		function checkAll(bx) {
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/account/posts.blade.php ENDPATH**/ ?>