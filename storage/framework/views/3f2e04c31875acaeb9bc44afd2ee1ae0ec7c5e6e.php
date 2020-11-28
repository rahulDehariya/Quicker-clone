<?php $__env->startSection('search'); ?>
	##parent-placeholder-3559d7accf00360971961ca18989adc0614089c0##
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'pages.inc.contact-intro', 'pages.inc.contact-intro'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row clearfix">
				
				<?php if(isset($errors) and $errors->any()): ?>
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong><?php echo e(t('oops_an_error_has_occurred')); ?></strong></h5>
							<ul class="list list-check">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo e($error); ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>

				<?php if(Session::has('flash_notification')): ?>
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<div class="col-md-12">
					<div class="contact-form">
						<h5 class="list-title gray mt-0">
							<strong><?php echo e(t('Contact Us')); ?></strong>
						</h5>

						<form class="form-horizontal" method="post" action="<?php echo e(lurl(trans('routes.contact'))); ?>">
							<?php echo csrf_field(); ?>

							<fieldset>
								<div class="row">
									<div class="col-md-6">
										<?php $firstNameError = (isset($errors) and $errors->has('first_name')) ? ' is-invalid' : ''; ?>
										<div class="form-group required">
											<input id="first_name" name="first_name" type="text" placeholder="<?php echo e(t('first_name')); ?>"
												   class="form-control<?php echo e($firstNameError); ?>" value="<?php echo e(old('first_name')); ?>">
										</div>
									</div>

									<div class="col-md-6">
										<?php $lastNameError = (isset($errors) and $errors->has('last_name')) ? ' is-invalid' : ''; ?>
										<div class="form-group required">
											<input id="last_name" name="last_name" type="text" placeholder="<?php echo e(t('last_name')); ?>"
												   class="form-control<?php echo e($lastNameError); ?>" value="<?php echo e(old('last_name')); ?>">
										</div>
									</div>

									<div class="col-md-6">
										<?php $companyNameError = (isset($errors) and $errors->has('company_name')) ? ' is-invalid' : ''; ?>
										<div class="form-group required">
											<input id="company_name" name="company_name" type="text" placeholder="<?php echo e(t('company_name')); ?>"
												   class="form-control<?php echo e($companyNameError); ?>" value="<?php echo e(old('company_name')); ?>">
										</div>
									</div>

									<div class="col-md-6">
										<?php $emailError = (isset($errors) and $errors->has('email')) ? ' is-invalid' : ''; ?>
										<div class="form-group required">
											<input id="email" name="email" type="text" placeholder="<?php echo e(t('email_address')); ?>" class="form-control<?php echo e($emailError); ?>"
												   value="<?php echo e(old('email')); ?>">
										</div>
									</div>

									<div class="col-md-12">
										<?php $messageError = (isset($errors) and $errors->has('message')) ? ' is-invalid' : ''; ?>
										<div class="form-group required">
											<textarea class="form-control<?php echo e($messageError); ?>" id="message" name="message" placeholder="<?php echo e(t('Message')); ?>"
													  rows="7"><?php echo e(old('message')); ?></textarea>
										</div>
										
										<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.recaptcha', 'layouts.inc.tools.recaptcha'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-lg"><?php echo e(t('submit')); ?></button>
										</div>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script src="<?php echo e(url('assets/js/form-validation.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/pages/contact.blade.php ENDPATH**/ ?>