<div class="modal fade" id="quickLogin" tabindex="-1" role="dialog">
	<div class="modal-dialog  modal-sm">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title"><i class="icon-login fa"></i> <?php echo e(t('log_in')); ?> </h4>
				
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<form role="form" method="POST" action="<?php echo e(lurl(trans('routes.login'))); ?>">
				<?php echo csrf_field(); ?>

				<div class="modal-body">

					<?php if(isset($errors) and $errors->any() and old('quickLoginForm')=='1'): ?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul class="list list-check">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo e($error); ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
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
						<div class="row mb-3 d-flex justify-content-center pl-2 pr-2">
							<?php if(config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret')): ?>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
								<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-fb">
									<a href="<?php echo e(lurl('auth/facebook')); ?>" class="btn-fb" title="<?php echo strip_tags(t('Login with Facebook')); ?>">
										<i class="icon-facebook-rect"></i> Facebook
									</a>
								</div>
							</div>
							<?php endif; ?>
							<?php if(config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret')): ?>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
								<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-lkin">
									<a href="<?php echo e(lurl('auth/linkedin')); ?>" class="btn-lkin" title="<?php echo strip_tags(t('Login with LinkedIn')); ?>">
										<i class="icon-linkedin"></i> LinkedIn
									</a>
								</div>
							</div>
							<?php endif; ?>
							<?php if(config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret')): ?>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
								<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-tw">
									<a href="<?php echo e(lurl('auth/twitter')); ?>" class="btn-tw" title="<?php echo strip_tags(t('Login with Twitter')); ?>">
										<i class="icon-twitter-bird"></i> Twitter
									</a>
								</div>
							</div>
							<?php endif; ?>
							<?php if(config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret')): ?>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
								<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-danger">
									<a href="<?php echo e(lurl('auth/google')); ?>" class="btn-danger" title="<?php echo strip_tags(t('Login with Google')); ?>">
										<i class="icon-googleplus-rect"></i> Google
									</a>
								</div>
							</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					
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
						<label for="login" class="control-label"><?php echo e(t('login') . ' (' . getLoginLabel() . ')'); ?></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-user fa"></i></span>
							</div>
							<input id="mLogin" name="login" type="text" placeholder="<?php echo e(getLoginLabel()); ?>" class="form-control<?php echo e($loginError); ?>" value="<?php echo e($loginValue); ?>">
						</div>
					</div>
					
					<!-- password -->
					<?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
					<div class="form-group">
						<label for="password" class="control-label"><?php echo e(t('password')); ?></label>
						<div class="input-group show-pwd-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-lock fa"></i></span>
							</div>
							<input id="mPassword" name="password" type="password" class="form-control<?php echo e($passwordError); ?>" placeholder="<?php echo e(t('password')); ?>" autocomplete="off">
							<span class="icon-append show-pwd">
								<button type="button" class="eyeOfPwd">
									<i class="far fa-eye-slash"></i>
								</button>
							</span>
						</div>
					</div>
					
					<!-- remember -->
					<?php $rememberError = (isset($errors) and $errors->has('remember')) ? ' is-invalid' : ''; ?>
					<div class="form-group">
						<label class="checkbox form-check-label pull-left mt-2" style="font-weight: normal;">
							<input type="checkbox" value="1" name="remember" id="mRemember" class="<?php echo e($rememberError); ?>"> <?php echo e(t('keep_me_logged_in')); ?>

						</label>
						<p class="pull-right mt-2">
							<a href="<?php echo e(lurl('password/reset')); ?>"> <?php echo e(t('lost_your_password')); ?> </a> / <a href="<?php echo e(lurl(trans('routes.register'))); ?>"><?php echo e(t('register')); ?></a>
						</p>
						<div style=" clear:both"></div>
					</div>
					
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.recaptcha', 'layouts.inc.tools.recaptcha'], ['label' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					
					<input type="hidden" name="quickLoginForm" value="1">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(t('Cancel')); ?></button>
					<button type="submit" class="btn btn-success pull-right"><?php echo e(t('log_in')); ?></button>
				</div>
			</form>
			
		</div>
	</div>
</div>
<?php /**PATH /home/developer/public_html/resources/views/layouts/inc/modal/login.blade.php ENDPATH**/ ?>