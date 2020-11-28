<div class="modal fade" id="contactUser" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title">
					<i class="icon-mail-2"></i> <?php echo e(t('contact_advertiser')); ?>

				</h4>
				
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<form role="form" method="POST" action="<?php echo e(lurl('posts/' . $post->id . '/contact')); ?>" enctype="multipart/form-data">
				<?php echo csrf_field(); ?>

				<div class="modal-body">

					<?php if(isset($errors) and $errors->any() and old('messageForm')=='1'): ?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul class="list list-check">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo e($error); ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					<?php endif; ?>
					
					<?php if(auth()->check()): ?>
						<input type="hidden" name="from_name" value="<?php echo e(auth()->user()->name); ?>">
						<?php if(!empty(auth()->user()->email)): ?>
							<input type="hidden" name="from_email" value="<?php echo e(auth()->user()->email); ?>">
						<?php else: ?>
							<!-- from_email -->
							<?php $fromEmailError = (isset($errors) and $errors->has('from_email')) ? ' is-invalid' : ''; ?>
							<div class="form-group required">
								<label for="from_email" class="control-label"><?php echo e(t('E-mail')); ?>

									<?php if(!isEnabledField('phone')): ?>
										<sup>*</sup>
									<?php endif; ?>
								</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-mail"></i></span>
									</div>
									<input id="from_email" name="from_email" type="text" placeholder="<?php echo e(t('ie_email')); ?>"
										   class="form-control<?php echo e($fromEmailError); ?>" value="<?php echo e(old('from_email', auth()->user()->email)); ?>">
								</div>
							</div>
						<?php endif; ?>
					<?php else: ?>
						<!-- from_name -->
						<?php $fromNameError = (isset($errors) and $errors->has('from_name')) ? ' is-invalid' : ''; ?>
						<div class="form-group required">
							<label for="from_name" class="control-label"><?php echo e(t('Name')); ?> <sup>*</sup></label>
							<div class="input-group">
								<input id="from_name"
									   name="from_name"
									   class="form-control<?php echo e($fromNameError); ?>"
									   placeholder="<?php echo e(t('your_name')); ?>"
									   type="text"
									   value="<?php echo e(old('from_name')); ?>"
								>
							</div>
						</div>
							
						<!-- from_email -->
						<?php $fromEmailError = (isset($errors) and $errors->has('from_email')) ? ' is-invalid' : ''; ?>
						<div class="form-group required">
							<label for="from_email" class="control-label"><?php echo e(t('E-mail')); ?>

								<?php if(!isEnabledField('phone')): ?>
									<sup>*</sup>
								<?php endif; ?>
							</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-mail"></i></span>
								</div>
								<input id="from_email" name="from_email" type="text" placeholder="<?php echo e(t('ie_email')); ?>"
									   class="form-control<?php echo e($fromEmailError); ?>" value="<?php echo e(old('from_email')); ?>">
							</div>
						</div>
					<?php endif; ?>
					
					<!-- from_phone -->
					<?php $fromPhoneError = (isset($errors) and $errors->has('from_phone')) ? ' is-invalid' : ''; ?>
					<div class="form-group required">
						<label for="phone" class="control-label"><?php echo e(t('phone_number')); ?>

							<?php if(!isEnabledField('email')): ?>
								<sup>*</sup>
							<?php endif; ?>
						</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span id="phoneCountry" class="input-group-text"><i class="icon-phone-1"></i></span>
							</div>
							<input id="from_phone"
								   name="from_phone"
								   type="text"
								   placeholder="<?php echo e(t('phone_number')); ?>"
								   maxlength="60"
								   class="form-control<?php echo e($fromPhoneError); ?>"
								   value="<?php echo e(old('from_phone', (auth()->check()) ? auth()->user()->phone : '')); ?>"
							>
						</div>
					</div>
					
					<!-- message -->
					<?php $messageError = (isset($errors) and $errors->has('message')) ? ' is-invalid' : ''; ?>
					<div class="form-group required">
						<label for="message" class="control-label">
							<?php echo e(t('Message')); ?> <span class="text-count">(500 max)</span> <sup>*</sup>
						</label>
						<textarea id="message"
								  name="message"
								  class="form-control required<?php echo e($messageError); ?>"
								  placeholder="<?php echo e(t('your_message_here')); ?>"
								  rows="5"
						><?php echo e(old('message')); ?></textarea>
					</div>

					<?php if(isset($parentCat) and isset($parentCat->type) and in_array($parentCat->type, ['job-offer'])): ?>
						<!-- filename -->
						<?php $filenameError = (isset($errors) and $errors->has('filename')) ? ' is-invalid' : ''; ?>
						<div class="form-group required" <?php echo (config('lang.direction')=='rtl') ? 'dir="rtl"' : ''; ?>>
							<label for="filename" class="control-label<?php echo e($filenameError); ?>"><?php echo e(t('Resume')); ?> </label>
							<input id="filename" name="filename" type="file" class="file<?php echo e($filenameError); ?>">
							<small id="" class="form-text text-muted">
								<?php echo e(t('file_types', ['file_types' => showValidFileTypes('file')])); ?>

							</small>
						</div>
						<input type="hidden" name="parentCatType" value="<?php echo e($parentCat->type); ?>">
					<?php endif; ?>
					
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.recaptcha', 'layouts.inc.tools.recaptcha'], ['label' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					
					<input type="hidden" name="country_code" value="<?php echo e(config('country.code')); ?>">
					<input type="hidden" name="post_id" value="<?php echo e($post->id); ?>">
					<input type="hidden" name="messageForm" value="1">
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(t('Cancel')); ?></button>
					<button type="submit" class="btn btn-success pull-right"><?php echo e(t('send_message')); ?></button>
				</div>
			</form>
			
		</div>
	</div>
</div>
<?php $__env->startSection('after_styles'); ?>
	##parent-placeholder-bb86d4c64894d7d4416e528718347e64591a36f9##
	<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css')); ?>" rel="stylesheet">
	<?php if(config('lang.direction') == 'rtl'): ?>
		<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css')); ?>" rel="stylesheet">
	<?php endif; ?>
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
	</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    ##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
	
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/fa/theme.js')); ?>" type="text/javascript"></script>
	<?php if(file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js')): ?>
		<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js')); ?>" type="text/javascript"></script>
	<?php endif; ?>

	<script>
		/* Initialize with defaults (Resume) */
		$('#filename').fileinput(
		{
			theme: "fa",
            language: '<?php echo e(config('app.locale')); ?>',
			<?php if(config('lang.direction') == 'rtl'): ?>
				rtl: true,
			<?php endif; ?>
			showPreview: false,
			allowedFileExtensions: <?php echo getUploadFileTypes('file', true); ?>,
			showUpload: false,
			showRemove: false,
			maxFileSize: <?php echo e((int)config('settings.upload.max_file_size', 1000)); ?>

		});
	</script>
	<script>
		$(document).ready(function () {
			<?php if($errors->any()): ?>
				<?php if($errors->any() and old('messageForm')=='1'): ?>
					$('#contactUser').modal();
				<?php endif; ?>
			<?php endif; ?>
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH /home/developer/public_html/resources/views/post/inc/compose-message.blade.php ENDPATH**/ ?>