<div id="recoverform">
	<div class="logo">
		<h3 class="font-weight-medium mb-3"><?php echo e(trans('admin.reset_password')); ?></h3>
		<span class="text-muted"><?php echo e(trans('admin.reset_password_info')); ?></span>
	</div>
	
	<div class="row mt-3">
		
		<form class="col-12" action="<?php echo e(admin_url('password/email')); ?>" method="post">
			<?php echo csrf_field(); ?>

			
			
			<div class="form-group row<?php echo e($errors->has('email') ? ' has-danger' : ''); ?>">
				<div class="col-12">
					<input class="form-control<?php echo e($errors->has('email') ? ' form-control-danger' : ''); ?>"
						   type="email"
						   name="email"
						   value="<?php echo e(old('email')); ?>"
						   placeholder="<?php echo e(trans('admin.email_address')); ?>"
					>
					
					<?php if($errors->has('email')): ?>
						<small class="form-control-feedback"><?php echo e($errors->first('email')); ?></small>
					<?php endif; ?>
				</div>
			</div>
			
			<?php echo $__env->make('layouts.inc.tools.recaptcha', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			
			
			<div class="form-group">
				<div class="d-flex">
					<div class="ml-auto">
						<a href="javascript:void(0)" id="to-login" class="text-muted float-right">
							<i class="fas fa-sign-in-alt mr-1"></i> <?php echo e(trans('admin.login')); ?>

						</a>
					</div>
				</div>
			</div>
			
			
			<div class="row mt-3">
				<div class="col-12">
					<button class="btn btn-block btn-lg btn-primary" type="submit" name="action"><?php echo e(trans('admin.reset')); ?></button>
				</div>
			</div>
		</form>
	</div>
</div><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/auth/passwords/inc/recover-form.blade.php ENDPATH**/ ?>