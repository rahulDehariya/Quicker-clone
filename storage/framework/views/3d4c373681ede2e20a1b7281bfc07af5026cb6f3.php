<div class="col-lg-6 col-md-12">
	<div class="card border-top border-primary shadow-sm">
		<div class="card-body">
			
			<div class="d-md-flex">
				<div>
					<h4 class="card-title font-weight-bold">
						<span class="lstick d-inline-block align-middle"></span><?php echo e(trans('admin.Latest Ads')); ?>

					</h4>
				</div>
				<div class="ml-auto">
					<a href="<?php echo e(url(config('app.locale') . '/posts/create')); ?>" target="_blank" class="btn btn-sm btn-light rounded shadow pull-left">
						<?php echo e(trans('admin.Post New Ad')); ?>

					</a>
					<a href="<?php echo e(admin_url('posts')); ?>" class="btn btn-sm btn-primary rounded shadow pull-right">
						<?php echo e(trans('admin.View All Ads')); ?>

					</a>
				</div>
			</div>
			
			<div class="table-responsive mt-3 no-wrap">
				<table class="table v-middle mb-0">
					<thead>
					<tr>
						<th class="border-0"><?php echo e(trans('admin.ID')); ?></th>
						<th class="border-0"><?php echo e(mb_ucfirst(trans('admin.title'))); ?></th>
						<th class="border-0"><?php echo e(mb_ucfirst(trans('admin.country'))); ?></th>
						<th class="border-0"><?php echo e(trans('admin.Status')); ?></th>
						<th class="border-0"><?php echo e(trans('admin.Date')); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php if($latestPosts->count() > 0): ?>
						<?php $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td class="td-nowrap"><?php echo e($post->id); ?></td>
								<td><?php echo getPostUrl($post); ?></td>
								<td class="td-nowrap"><?php echo getCountryFlag($post); ?></td>
								<td class="td-nowrap">
									<?php if(isVerifiedPost($post)): ?>
										<span class="badge badge-success"><?php echo e(trans('admin.Activated')); ?></span>
									<?php else: ?>
										<span class="badge badge-warning text-white"><?php echo e(trans('admin.Unactivated')); ?></span>
									<?php endif; ?>
								</td>
								<td class="td-nowrap">
									<?php
										try {
											$post->created_at = (new \Date($post->created_at))->timezone(config('app.timezone'));
										} catch (\Exception $e) {}
									?>
									<div class="sparkbar" data-color="#00a65a" data-height="20">
										<?php echo e($post->created_at->formatLocalized(config('settings.app.default_datetime_format'))); ?>

									</div>
								</td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php else: ?>
						<tr>
							<td colspan="5">
								<?php echo e(trans('admin.No ads found')); ?>

							</td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>

<?php $__env->startPush('dashboard_styles'); ?>
	<style>
		.td-nowrap {
			width: 10px;
			white-space: nowrap;
		}
	</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('dashboard_scripts'); ?>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/developer/public_html/resources/views/vendor/admin/dashboard/inc/latest-posts.blade.php ENDPATH**/ ?>