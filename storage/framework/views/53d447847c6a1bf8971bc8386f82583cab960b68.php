<?php if(
		config('settings.security.recaptcha_activation')
		and config('recaptcha.site_key')
		and config('recaptcha.secret_key')
	): ?>
	<?php if(config('recaptcha.version') == 'v2'): ?>
		<!-- recaptcha -->
		<?php if(isFromAdminPanel()): ?>
			
			<?php $recaptchaError = (isset($errors) and $errors->has('g-recaptcha-response')) ? ' has-error' : ''; ?>
			<div class="form-group required<?php echo e($recaptchaError); ?>">
				<div class="no-label">
					<?php echo recaptchaHtmlFormSnippet(); ?>

				</div>
				
				<?php if($errors->has('g-recaptcha-response')): ?>
					<span class="help-block<?php echo e($recaptchaError); ?>">
						<strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong>
					</span>
				<?php endif; ?>
			</div>
			
		<?php else: ?>
			
			<?php $recaptchaError = (isset($errors) and $errors->has('g-recaptcha-response')) ? ' is-invalid' : ''; ?>
			<?php if(isset($colLeft) and isset($colRight)): ?>
				<div class="form-group row required<?php echo e($recaptchaError); ?>">
					<label class="<?php echo e($colLeft); ?> col-form-label" for="g-recaptcha-response">
						<?php if(isset($label) and $label == true): ?>
							<?php echo e(t('We do not like robots')); ?>

						<?php endif; ?>
					</label>
					<div class="<?php echo e($colRight); ?>">
						<?php echo recaptchaHtmlFormSnippet(); ?>

					</div>
				</div>
			<?php else: ?>
				<?php if(isset($label) and $label == true): ?>
					<div class="form-group required<?php echo e($recaptchaError); ?>">
						<label class="control-label" for="g-recaptcha-response"><?php echo e(t('We do not like robots')); ?></label>
						<div>
							<?php echo recaptchaHtmlFormSnippet(); ?>

						</div>
					</div>
				<?php elseif(isset($noLabel) and $noLabel == true): ?>
					<div class="form-group required<?php echo e($recaptchaError); ?>">
						<div class="no-label">
							<?php echo recaptchaHtmlFormSnippet(); ?>

						</div>
					</div>
				<?php else: ?>
					<div class="form-group required<?php echo e($recaptchaError); ?>">
						<div>
							<?php echo recaptchaHtmlFormSnippet(); ?>

						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			
		<?php endif; ?>
		
	<?php else: ?>
		<input type="hidden" name="g-recaptcha-response" id="gRecaptchaResponse">
	<?php endif; ?>
<?php endif; ?>

<?php $__env->startSection('recaptcha_scripts'); ?>
	<?php if(
		config('settings.security.recaptcha_activation')
		and config('recaptcha.site_key')
		and config('recaptcha.secret_key')
	): ?>
		<style>
			.is-invalid .g-recaptcha iframe,
			.has-error .g-recaptcha iframe {
				border: 1px solid #f85359;
			}
		</style>
		<?php if(config('recaptcha.version') == 'v3'): ?>
			<script type="text/javascript">
				function myCustomValidation(token){
					/* read HTTP status */
					/* console.log(token); */
					
					if ($('#gRecaptchaResponse').length) {
						$('#gRecaptchaResponse').val(token);
					}
				}
			</script>
			<?php echo recaptchaApiV3JsScriptTag([
				'action' 		    => request()->path(),
				'custom_validation' => 'myCustomValidation'
			]); ?>

		<?php else: ?>
			<?php echo recaptchaApiJsScriptTag(); ?>

		<?php endif; ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?><?php /**PATH /home/developer/public_html/resources/views/layouts/inc/tools/recaptcha.blade.php ENDPATH**/ ?>