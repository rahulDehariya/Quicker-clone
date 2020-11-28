<?php $__env->startSection('content'); ?>
	<?php if(!(isset($paddingTopExists) and $paddingTopExists)): ?>
		<div class="h-spacer"></div>
	<?php endif; ?>
	<div class="main-container">
		<div class="container">
			<div class="row">

				<?php if(isset($errors) and $errors->any()): ?>
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
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
				
				<?php if(
					config('settings.social_auth.social_login_activation')
					and (
						(config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret'))
						or (config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret'))
						or (config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret'))
						or (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
						)
					): ?>
					<div class="col-xl-12">
						<div class="row d-flex justify-content-center">
							<div class="col-8">
								<div class="row mb-3 d-flex justify-content-center pl-3 pr-3">
									<?php if(config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret')): ?>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-fb">
											<a href="<?php echo e(lurl('auth/facebook')); ?>" class="btn-fb"><i class="icon-facebook-rect"></i> <?php echo t('Login with Facebook'); ?></a>
										</div>
									</div>
									<?php endif; ?>
									<?php if(config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret')): ?>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-lkin">
											<a href="<?php echo e(lurl('auth/linkedin')); ?>" class="btn-lkin"><i class="icon-linkedin"></i> <?php echo t('Login with LinkedIn'); ?></a>
										</div>
									</div>
									<?php endif; ?>
									<?php if(config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret')): ?>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-tw">
											<a href="<?php echo e(lurl('auth/twitter')); ?>" class="btn-tw"><i class="icon-twitter-bird"></i> <?php echo t('Login with Twitter'); ?></a>
										</div>
									</div>
									<?php endif; ?>
									<?php if(config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret')): ?>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-danger">
											<a href="<?php echo e(lurl('auth/google')); ?>" class="btn-danger"><i class="icon-googleplus-rect"></i> <?php echo t('Login with Google'); ?></a>
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
					
				<div class="col-lg-5 col-md-8 col-sm-10 col-xs-12 login-box mt-3">
					<form id="loginForm" role="form" method="POST" action="<?php echo e(url()->current()); ?>">
						<?php echo csrf_field(); ?>

						<input type="hidden" name="country" value="<?php echo e(config('country.code')); ?>">
						<div class="card card-default">
							
							<div class="panel-intro text-center">
								<h2 class="logo-title"><strong><?php echo e(t('log_in')); ?></strong></h2>
							</div>
							
							<div class="card-body">
								<?php
									$loginValue = (session()->has('login')) ? session('login') : old('login');
									$loginField = getLoginField($loginValue);
									if ($loginField == 'phone') {
										$loginValue = phoneFormat($loginValue, old('country', config('country.code')));
									}
								?>
								<!-- login -->
								<?php $loginError = (isset($errors) and $errors->has('login')) ? ' is-invalid' : ''; ?>
								<div class="form-group">
									<label for="login" class="col-form-label"><?php echo e(t('login') . ' (' . getLoginLabel() . ')'); ?>:</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-user fa"></i></span>
										</div>
										<input id="login" name="login" type="text" placeholder="<?php echo e(getLoginLabel()); ?>" class="form-control<?php echo e($loginError); ?>" value="<?php echo e($loginValue); ?>">
									</div>
								</div>
								
								<!-- password -->
								<?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
								<div class="form-group">
									<label for="password" class="col-form-label"><?php echo e(t('password')); ?>:</label>
									<div class="input-group show-pwd-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-lock fa"></i></span>
										</div>
										<input id="password" name="password" type="password" class="form-control<?php echo e($passwordError); ?>" placeholder="<?php echo e(t('password')); ?>" autocomplete="off">
										<span class="icon-append show-pwd">
											<button type="button" class="eyeOfPwd">
												<i class="far fa-eye-slash"></i>
											</button>
										</span>
									</div>
								</div>
								
								<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.recaptcha', 'layouts.inc.tools.recaptcha'], ['noLabel' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
								<!-- Submit -->
								<div class="form-group">
									<button id="loginBtn" class="btn btn-primary btn-block"> <?php echo e(t('log_in')); ?> </button>
								</div>
							</div>
							
							<div class="card-footer">
								<label class="checkbox pull-left mt-2 mb-2">
									<input type="checkbox" value="1" name="remember" id="remember">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description"> <?php echo e(t('keep_me_logged_in')); ?></span>
								</label>
								<div class="text-center pull-right mt-2 mb-2">
									<a href="<?php echo e(lurl('password/reset')); ?>"> <?php echo e(t('lost_your_password')); ?> </a>
								</div>
								<div style=" clear:both"></div>
							</div>
						</div>
					</form>

					<div class="login-box-btm text-center">
						<p>
							<?php echo e(t('do_not_have_an_account')); ?><br>
							<a href="<?php echo e(lurl(trans('routes.register'))); ?>"><strong><?php echo e(t('sign_up')); ?> !</strong></a>
						</p>
					</div>
				</div>
				
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
		$(document).ready(function () {
			$("#loginBtn").click(function () {
				$("#loginForm").submit();
				return false;
			});
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>