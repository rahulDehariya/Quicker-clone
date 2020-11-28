<div class="col-lg-6 col-md-12">
	<div class="card border-top border-primary shadow-sm">
		<div class="card-body">
			
			<div class="d-md-flex">
				<div>
					<h4 class="card-title font-weight-bold">
						<span class="lstick d-inline-block align-middle"></span><?php echo e(trans('admin.Latest Users')); ?>

					</h4>
				</div>
				<div class="ml-auto">
					<a href="<?php echo e(admin_url('users')); ?>" class="btn btn-sm btn-primary rounded shadow pull-right">
						<?php echo e(trans('admin.View All Users')); ?>

					</a>
				</div>
			</div>
			
			<div class="table-responsive mt-3 no-wrap">
				<table class="table v-middle mb-0">
					<thead>
					<tr>
						<th class="border-0"><?php echo e(trans('admin.ID')); ?></th>
						<th class="border-0"><?php echo e(trans('admin.Name')); ?></th>
						<th class="border-0"><?php echo e(mb_ucfirst(trans('admin.country'))); ?></th>
						<th class="border-0"><?php echo e(trans('admin.Status')); ?></th>
						<th class="border-0"><?php echo e(trans('admin.Date')); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php if($latestUsers->count() > 0): ?>
						<?php $__currentLoopData = $latestUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td class="td-nowrap"><a href="<?php echo e(admin_url('users/' . $user->id . '/edit')); ?>"><?php echo e($user->id); ?></a></td>
								<td>
									<?php
										$url = admin_url('users/' . $user->id . '/edit');
										echo linkStrLimit($url, $user->name, 35);
									?>
								</td>
								<td class="td-nowrap"><?php echo getCountryFlag($user); ?></td>
								<td class="td-nowrap">
									<?php if(isVerifiedUser($user)): ?>
										<span class="badge badge-success"><?php echo e(trans('admin.Activated')); ?></span>
									<?php else: ?>
										<span class="badge badge-warning text-white"><?php echo e(trans('admin.Unactivated')); ?></span>
									<?php endif; ?>
								</td>
								<td class="td-nowrap">
									<?php
										try {
											$user->created_at = (new \Date($user->created_at))->timezone(config('app.timezone'));
										} catch (\Exception $e) {}
									?>
									<div class="sparkbar" data-color="#00a65a" data-height="20">
										<?php echo e($user->created_at->formatLocalized(config('settings.app.default_datetime_format'))); ?>

									</div>
								</td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php else: ?>
						<tr>
							<td colspan="5">
								<?php echo e(trans('admin.No users found')); ?>

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
<?php /**PATH /home/developer/public_html/resources/views/vendor/admin/dashboard/inc/latest-users.blade.php ENDPATH**/ ?>