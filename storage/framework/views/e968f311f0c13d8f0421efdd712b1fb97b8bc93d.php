<?php $__env->startPush('after_styles_stack'); ?>
	<?php echo $__env->make('layouts.inc.tools.wysiwyg.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
	
	<?php if(config('settings.single.publication_form_type') == '2'): ?>
		<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css')); ?>" rel="stylesheet">
		<?php if(config('lang.direction') == 'rtl'): ?>
			<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css')); ?>" rel="stylesheet">
		<?php endif; ?>
		
		<style>
			.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
				box-shadow: 0 0 5px 0 #666666;
			}
			.file-loading:before {
				content: " <?php echo e(t('Loading')); ?>...";
			}
			/* Preview Frame Size */
			/*
			.krajee-default.file-preview-frame .kv-file-content,
			.krajee-default .file-caption-info,
			.krajee-default .file-size-info {
				width: 90px;
			}
			*/
			.krajee-default.file-preview-frame .kv-file-content {
				height: auto;
			}
			.krajee-default.file-preview-frame .file-thumbnail-footer {
				height: 30px;
			}
		</style>
	<?php endif; ?>
	
	<link href="<?php echo e(url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('after_scripts_stack'); ?>
	<?php echo $__env->make('layouts.inc.tools.wysiwyg.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
	<?php if(file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js')): ?>
		<script src="<?php echo e(url('assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js')); ?>" type="text/javascript"></script>
	<?php endif; ?>
	
	
	<?php if(config('settings.single.publication_form_type') == '2'): ?>
		<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/fa/theme.js')); ?>" type="text/javascript"></script>
		<?php if(file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js')): ?>
			<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js')); ?>" type="text/javascript"></script>
		<?php endif; ?>
	<?php endif; ?>
	
	<script src="<?php echo e(url('assets/plugins/momentjs/moment.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')); ?>" type="text/javascript"></script>
	
	<?php
	$postId = isset($post, $post->id) ? $post->id : '';
	$postTypeId = isset($post, $post->post_type_id) ? $post->post_type_id : '0';
	$countryCode = (isset($post, $post->country_code) and !empty($post->country_code)) ? $post->country_code : config('country.code', 0);
	$selectedAdminCode = (isset($admin) and !empty($admin)) ? $admin->code : 0;
	$cityId = isset($post, $post->city_id) ? (int)$post->city_id : 0;
	?>
	
	<script>
		/* Translation */
		var lang = {
			'select': {
				'country': "<?php echo e(t('select_a_country')); ?>",
				'admin': "<?php echo e(t('select_a_location')); ?>",
				'city': "<?php echo e(t('select_a_city')); ?>"
			},
			'price': "<?php echo e(t('price')); ?>",
			'salary': "<?php echo e(t('Salary')); ?>",
			'nextStepBtnLabel': {
				'next': "<?php echo e(t('Next')); ?>",
				'submit': "<?php echo e(t('Update')); ?>"
			}
		};
		
		var stepParam = 0;
		
		/* Category */
		/* Custom Fields */
		var errors = '<?php echo addslashes($errors->toJson()); ?>';
		var oldInput = '<?php echo addslashes(collect(session()->getOldInput('cf'))->toJson()); ?>';
		var postId = '<?php echo e($postId); ?>';
		
		/* Permanent Posts */
		var permanentPostsEnabled = '<?php echo e(config('settings.single.permanent_posts_enabled', 0)); ?>';
		var postTypeId = '<?php echo e(old('post_type_id', $postTypeId)); ?>';
		
		/* Locations */
		var countryCode = '<?php echo e(old('country_code', $countryCode)); ?>';
		var adminType = '<?php echo e(config('country.admin_type', 0)); ?>';
		var selectedAdminCode = '<?php echo e(old('admin_code', $selectedAdminCode)); ?>';
		var cityId = '<?php echo e(old('city_id', $cityId)); ?>';
		
		/* Packages */
		var packageIsEnabled = false;
		<?php if(isset($packages, $paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0): ?>
			packageIsEnabled = true;
		<?php endif; ?>
	</script>
	<script>
		
		<?php if(config('settings.single.publication_form_type') == '2'): ?>
			<?php if(getSegment(1) == 'create'): ?>
				
				/* Images Upload */
				$('.post-picture').fileinput(
				{
					theme: "fa",
					language: '<?php echo e(config('app.locale')); ?>',
					<?php if(config('lang.direction') == 'rtl'): ?>
					rtl: true,
					<?php endif; ?>
					dropZoneEnabled: false,
					overwriteInitial: true,
					showCaption: true,
					showPreview: true,
					showClose: true,
					showUpload: false,
					showRemove: false,
					previewFileType: 'image',
					allowedFileExtensions: <?php echo getUploadFileTypes('image', true); ?>,
					browseLabel: '<?php echo t('Browse'); ?>',
					minFileSize: <?php echo e((int)config('settings.upload.min_image_size', 0)); ?>, 
					maxFileSize: <?php echo e((int)config('settings.upload.max_image_size', 1000)); ?>, 
					/* Remove Drag-Drop Icon (in footer) */
					fileActionSettings: {
						dragIcon: '',
						dragTitle: ''
					},
					layoutTemplates: {
						/* Show Only Actions (in footer) */
						footer: '<div class="file-thumbnail-footer pt-2">{actions}</div>',
						/* Remove Delete Icon (in footer) */
						actionDelete: ''
					}
				});
			<?php else: ?>
				
				<?php if(isset($post, $picturesLimit) and is_numeric($picturesLimit) and $picturesLimit > 0): ?>
					<?php for($i = 0; $i <= $picturesLimit-1; $i++): ?>
						/* Images Upload */
						$('#picture<?php echo e($i); ?>').fileinput(
						{
							theme: "fa",
							language: '<?php echo e(config('app.locale')); ?>',
							<?php if(config('lang.direction') == 'rtl'): ?>
							rtl: true,
							<?php endif; ?>
							dropZoneEnabled: false,
							overwriteInitial: false,
							showCaption: true,
							showPreview: true,
							showClose: true,
							showUpload: false,
							showRemove: false,
							previewFileType: 'image',
							allowedFileExtensions: <?php echo getUploadFileTypes('image', true); ?>,
							browseLabel: '<?php echo t('Browse'); ?>',
							minFileSize: <?php echo e((int)config('settings.upload.min_image_size', 0)); ?>, 
							maxFileSize: <?php echo e((int)config('settings.upload.max_image_size', 1000)); ?>, 
							<?php if(isset($post->pictures, $post->pictures->get($i)->filename)): ?>
							/* Retrieve Existing Picture */
							initialPreview: [
								'<img src="<?php echo e(imgUrl($post->pictures->get($i)->filename, 'medium')); ?>" class="file-preview-image">',
							],
							initialPreviewConfig: [
							<?php
							// Get the file path
							$filePath = $post->pictures->get($i)->filename;
							
							// Get the file's deletion URL
							$deleteURL = lurl('posts/' . $post->id . '/photos/' . $post->pictures->get($i)->id . '/delete');
							
							// Get the file size
							try {
								$fileSize = (isset($disk) && $disk->exists($filePath)) ? (int)$disk->size($filePath) : 0;
							} catch (\Exception $e) {
								$fileSize = 0;
							}
							?>
								{
									caption: '<?php echo e(last(explode(DIRECTORY_SEPARATOR, $post->pictures->get($i)->filename))); ?>',
									size: <?php echo e($fileSize); ?>,
									url: '<?php echo e($deleteURL); ?>',
									key: <?php echo e((int)$post->pictures->get($i)->id); ?>

								}
							],
							<?php endif; ?>
							/* Remove Drag-Drop Icon (in footer) */
							fileActionSettings: {
								showDrag: false, /* Remove move/rearrange icon */
								showZoom: false, /* Remove zoom icon */
								removeIcon: '<i class="far fa-trash-alt" style="color: red;"></i>',
								indicatorNew: '<i class="fas fa-check-circle" style="color: #09c509;font-size: 20px;margin-top: -15px;display: block;"></i>'
							}
						});
					
						/* Delete picture */
						$('#picture<?php echo e($i); ?>').on('filepredelete', function(jqXHR) {
							var abort = true;
							if (confirm("<?php echo e(t('Are you sure you want to delete this picture')); ?>")) {
								abort = false;
							}
							return abort;
						});
					<?php endfor; ?>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
		
		$(document).ready(function() {
			/* Tags */
			$('#tags').tagit({
				fieldName: 'tags',
				placeholderText: '<?php echo e(t('add a tag')); ?>',
				caseSensitive: false,
				allowDuplicates: false,
				allowSpaces: false,
				tagLimit: <?php echo e((int)config('settings.single.tags_limit', 15)); ?>,
				singleFieldDelimiter: ','
			});
		});
	</script>
	
	<script src="<?php echo e(url('assets/js/app/d.select.category.js') . vTime()); ?>"></script>
	<script src="<?php echo e(url('assets/js/app/d.select.location.js') . vTime()); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/developer/public_html/resources/views/post/createOrEdit/inc/form-assets.blade.php ENDPATH**/ ?>