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
						<h2 class="title-2">
							<i class="icon-mail"></i> <?php echo e(t('Conversations')); ?>

						</h2>
						<div id="reloadBtn" class="mb30" style="display: none;">
							<a href="" class="btn btn-primary" class="tooltipHere" title="" data-placement="<?php echo e((config('lang.direction')=='rtl') ? 'left' : 'right'); ?>"
							   data-toggle="tooltip"
							   data-original-title="<?php echo e(t('Reload to see New Messages')); ?>"><i class="icon-arrows-cw"></i> <?php echo e(t('Reload')); ?></a>
							<br><br>
						</div>
						
						<div style="clear:both"></div>
						
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
										<th style="width:2%" data-type="numeric" data-sort-initial="true"></th>
										<th style="width:88%" data-sort-ignore="true"><?php echo e(t('Conversations')); ?></th>
										<th style="width:10%"><?php echo e(t('Option')); ?></th>
									</tr>
									</thead>
									<tbody>
									<?php
									if (isset($conversations) && $conversations->count() > 0):
										foreach($conversations as $key => $conversation):
									?>
									<tr>
										<td class="add-img-selector">
											<div class="checkbox">
												<label><input type="checkbox" name="entries[]" value="<?php echo e($conversation->id); ?>"></label>
											</div>
										</td>
										<td>
											<div style="word-break:break-all;">
												<strong><?php echo e(t('Received at')); ?>:</strong>
												<?php echo e($conversation->created_at->formatLocalized(config('settings.app.default_datetime_format'))); ?>

												<?php if(\App\Models\Message::conversationHasNewMessages($conversation)): ?>
													<i class="icon-flag text-primary"></i>
												<?php endif; ?>
												<br>
												<strong><?php echo e(t('Subject')); ?>:</strong>&nbsp;<?php echo e($conversation->subject); ?><br>
												<strong><?php echo e(t('Started by')); ?>:</strong>&nbsp;<?php echo e(\Illuminate\Support\Str::limit($conversation->from_name, 50)); ?>

												<?php echo (!empty($conversation->filename) and $disk->exists($conversation->filename)) ? ' <i class="icon-attach-2"></i> ' : ''; ?>&nbsp;
												|&nbsp;
												<a href="<?php echo e(lurl('account/conversations/' . $conversation->id . '/messages')); ?>">
													<?php echo e(t('Click here to read the messages')); ?>

												</a>
											</div>
										</td>
										<td class="action-td">
											<div>
												<p>
													<a class="btn btn-default btn-sm" href="<?php echo e(lurl('account/conversations/' . $conversation->id . '/messages')); ?>">
														<i class="icon-eye"></i> <?php echo e(t('View')); ?>

													</a>
												</p>
												<p>
													<a class="btn btn-danger btn-sm delete-action" href="<?php echo e(lurl('account/conversations/' . $conversation->id . '/delete')); ?>">
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
						
						<nav class="" aria-label="">
							<?php echo e((isset($conversations)) ? $conversations->links() : ''); ?>

						</nav>
						
						<div style="clear:both"></div>
					
					</div>
				</div>
				<!--/.page-content-->
				
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->

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
			
			$('a.delete-action, button.delete-action').click(function(e)
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/account/conversations.blade.php ENDPATH**/ ?>