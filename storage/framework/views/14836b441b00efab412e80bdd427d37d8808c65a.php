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
						<h2 class="title-2"><i class="icon-mail"></i> <?php echo e(t('Messages')); ?> </h2>
						
						<div style="clear:both"></div>
						
						<?php
						if (isset($conversation) && !empty($conversation) > 0):
						
							// Conversation URLs
							$consUrl = lurl('account/conversations');
							$conDelAllUrl = lurl('account/conversations/' . $conversation->id . '/messages/delete');
						?>
						<div class="table-responsive">
							<form name="listForm" method="POST" action="<?php echo e($conDelAllUrl); ?>">
								<?php echo csrf_field(); ?>

								<div class="table-action">
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
										<th data-sort-ignore="true" colspan="3">
											<a href="<?php echo e($consUrl); ?>"><i class="icon-level-up"></i> <?php echo e(t('Back')); ?></a>&nbsp;|&nbsp;
											<?php echo e(t("Conversation")); ?> #<?php echo e($conversation->id); ?>&nbsp;|&nbsp;
											<?php echo e($conversation->subject); ?>

										</th>
									</tr>
									</thead>
									<tbody>
									<!-- Main Conversation -->
									<tr>
										<td colspan="3">
											<strong><?php echo e(t('sender_name')); ?>:</strong> <?php echo e($conversation->from_name ?? '--'); ?><br>
											<strong><?php echo e(t('sender_email')); ?>:</strong> <?php echo e($conversation->from_email ?? '--'); ?><br>
											<strong><?php echo e(t('sender_phone')); ?>:</strong> <?php echo e($conversation->from_phone ?? '--'); ?><br>
											<hr>
											<?php echo nl2br($conversation->message); ?>

											<?php if(!empty($conversation->filename) and $disk->exists($conversation->filename)): ?>
												<br><br><a class="btn btn-info" href="<?php echo e(fileUrl($conversation->filename)); ?>"><?php echo e(t('Download')); ?></a>
											<?php endif; ?>
											<hr>
											<a class="btn btn-primary" href="#" data-toggle="modal" data-target="#replyTo<?php echo e($conversation->id); ?>">
												<i class="icon-reply"></i> <?php echo e(t('Reply')); ?>

											</a>
										</td>
									</tr>
									<!-- All Conversation's Messages -->
									<?php
									if (isset($messages) && $messages->count() > 0):
										foreach($messages as $key => $message):
									?>
									<tr>
										<?php if($message->from_user_id == auth()->user()->id): ?>
											<td class="add-img-selector">
												<div class="checkbox" style="width:2%">
													<label><input type="checkbox" name="entries[]" value="<?php echo e($message->id); ?>"></label>
												</div>
											</td>
											<td style="width:88%;">
												<div style="word-break:break-all;">
													<strong>
														<i class="icon-reply"></i> <?php echo e($message->from_name); ?>:
													</strong><br>
													<?php echo nl2br($message->message); ?>

													<?php if(!empty($message->filename) and $disk->exists($message->filename)): ?>
														<br><br><a class="btn btn-info" href="<?php echo e(fileUrl($message->filename)); ?>"><?php echo e(t('Download')); ?></a>
													<?php endif; ?>
												</div>
											</td>
											<td class="action-td" style="width:10%">
												<div>
													<p>
														<?php $conDelUrl = lurl('account/conversations/' . $conversation->id . '/messages/' . $message->id . '/delete'); ?>
														<a class="btn btn-danger btn-sm delete-action" href="<?php echo e($conDelUrl); ?>">
															<i class="fa fa-trash"></i> <?php echo e(t('Delete')); ?>

														</a>
													</p>
												</div>
											</td>
										<?php else: ?>
											<td colspan="3">
												<div style="word-break:break-all;">
													<strong><?php echo e($message->from_name); ?>:</strong><br>
													<?php echo nl2br($message->message); ?>

													<?php if(!empty($message->filename) and $disk->exists($message->filename)): ?>
														<br><br><a class="btn btn-info" href="<?php echo e(fileUrl($message->filename)); ?>"><?php echo e(t('Download')); ?></a>
													<?php endif; ?>
												</div>
											</td>
										<?php endif; ?>
									</tr>
									<?php endforeach; ?>
									<?php endif; ?>
									</tbody>
								</table>
								
								<?php if(isset($messages) && $messages->count() > 0): ?>
								<div class="table-action">
									<label for="checkAll">
										<input type="checkbox" id="checkAll">
										<?php echo e(t('Select')); ?>: <?php echo e(t('All')); ?> |
										<button type="submit" class="btn btn-sm btn-default delete-action">
											<i class="fa fa-trash"></i> <?php echo e(t('Delete')); ?>

										</button>
									</label>
								</div>
								<?php endif; ?>
								
							</form>
						</div>
						
						<nav>
							<?php echo e((isset($messages)) ? $messages->links() : ''); ?>

						</nav>
						<?php endif; ?>
						
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
	
	<?php if(isset($conversation) && $conversation->count() > 0): ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'account.inc.reply-message', 'account.inc.reply-message'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>

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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/account/messages.blade.php ENDPATH**/ ?>