<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-md-3 page-sidebar">
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
				<!--/.page-sidebar-->

				<div class="col-md-9 page-content">

					<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<?php if(isset($errors) and $errors->any()): ?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong><?php echo e(t('oops_an_error_has_occurred')); ?></strong></h5>
							<ul class="list list-check">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo e($error); ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					<?php endif; ?>
					
					<div id="avatarUploadError" class="center-block" style="width:100%; display:none"></div>
					<div id="avatarUploadSuccess" class="alert alert-success fade show" style="display:none;"></div>

					<div class="inner-box default-inner-box">
						<div class="row">
							<div class="col-md-5 col-xs-4 col-xxs-12">
								<h3 class="no-padding text-center-480 useradmin">
									<a href="">
										<?php if(!empty($userPhoto)): ?>
											<img id="userImg" class="userImg" src="<?php echo e($userPhoto); ?>" alt="user">&nbsp;
										<?php else: ?>
											<img id="userImg" class="userImg" src="<?php echo e(url('images/user.jpg')); ?>" alt="user">
										<?php endif; ?>
										<?php echo e($user->name); ?>

									</a>
								</h3>
							</div>
							<div class="col-md-7 col-xs-8 col-xxs-12">
								<div class="header-data text-center-xs">
									<!-- Conversations Stats -->
									<div class="hdata">
										<div class="mcol-left">
											<i class="fas fa-envelope ln-shadow"></i></div>
										<div class="mcol-right">
											<!-- Number of messages -->
											<p>
												<a href="<?php echo e(lurl('account/conversations')); ?>">
													<?php echo e(isset($countConversations) ? \App\Helpers\Number::short($countConversations) : 0); ?>

													<em><?php echo e(trans_choice('global.count_mails', getPlural($countConversations))); ?></em>
												</a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>
									
									<!-- Traffic Stats -->
									<div class="hdata">
										<div class="mcol-left">
											<i class="fa fa-eye ln-shadow"></i>
										</div>
										<div class="mcol-right">
											<!-- Number of visitors -->
											<p>
												<a href="<?php echo e(lurl('account/my-posts')); ?>">
													<?php $totalPostsVisits = (isset($countPostsVisits) and $countPostsVisits->total_visits) ? $countPostsVisits->total_visits : 0 ?>
													<?php echo e(\App\Helpers\Number::short($totalPostsVisits)); ?>

													<em><?php echo e(trans_choice('global.count_visits', getPlural($totalPostsVisits))); ?></em>
												</a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>

									<!-- Ads Stats -->
									<div class="hdata">
										<div class="mcol-left">
											<i class="icon-th-thumb ln-shadow"></i>
										</div>
										<div class="mcol-right">
											<!-- Number of ads -->
											<p>
												<a href="<?php echo e(lurl('account/my-posts')); ?>">
													<?php echo e(\App\Helpers\Number::short($countPosts)); ?>

													<em><?php echo e(trans_choice('global.count_posts', getPlural($countPosts))); ?></em>
												</a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>

									<!-- Favorites Stats -->
									<div class="hdata">
										<div class="mcol-left">
											<i class="fa fa-user ln-shadow"></i>
										</div>
										<div class="mcol-right">
											<!-- Number of favorites -->
											<p>
												<a href="<?php echo e(lurl('account/favourite')); ?>">
													<?php echo e(\App\Helpers\Number::short($countFavoritePosts)); ?>

													<em><?php echo e(trans_choice('global.count_favorites', getPlural($countFavoritePosts))); ?> </em>
												</a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="inner-box default-inner-box">
						<div class="welcome-msg">
							<h3 class="page-sub-header2 clearfix no-padding"><?php echo e(t('Hello')); ?> <?php echo e($user->name); ?> ! </h3>
							<span class="page-sub-header-sub small">
                                <?php echo e(t('You last logged in at')); ?>: <?php echo e($user->last_login_at->formatLocalized(config('settings.app.default_datetime_format'))); ?>

                            </span>
						</div>
						
						<div id="accordion" class="panel-group">
							<!-- PHOTO -->
							<div class="card card-default">
								<div class="card-header">
									<h4 class="card-title">
										<a href="#photoPanel" data-toggle="collapse" data-parent="#accordion"><?php echo e(t('Photo or Avatar')); ?></a>
									</h4>
								</div>
								<div class="panel-collapse collapse <?php echo e((old('panel')=='' or old('panel')=='photoPanel') ? 'show' : ''); ?>" id="photoPanel">
									<div class="card-body">
										<form name="details" class="form-horizontal" role="form" method="POST" action="<?php echo e(lurl('account/' . $user->id . '/photo')); ?>">
											<div class="row">
												<div class="col-xl-12 text-center">
													
													<?php $photoError = (isset($errors) and $errors->has('photo')) ? ' is-invalid' : ''; ?>
													<div class="photo-field">
														<div class="file-loading">
															<input id="photoField" name="photo" type="file" class="file <?php echo e($photoError); ?>">
														</div>
													</div>
												
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							
							<!-- USER -->
							<div class="card card-default">
								<div class="card-header">
									<h4 class="card-title">
										<a href="#userPanel" aria-expanded="true" data-toggle="collapse" data-parent="#accordion"><?php echo e(t('Account Details')); ?></a>
									</h4>
								</div>
								<div class="panel-collapse collapse <?php echo e((old('panel')=='' or old('panel')=='userPanel') ? 'show' : ''); ?>" id="userPanel">
									<div class="card-body">
										<form name="details" class="form-horizontal" role="form" method="POST" action="<?php echo e(url()->current()); ?>">
											<?php echo csrf_field(); ?>

											<input name="_method" type="hidden" value="PUT">
											<input name="panel" type="hidden" value="userPanel">

											<!-- gender_id -->
											<?php $genderIdError = (isset($errors) and $errors->has('gender_id')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label"><?php echo e(t('gender')); ?></label>
												<div class="col-md-9">
													<?php if($genders->count() > 0): ?>
                                                        <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<div class="form-check form-check-inline pt-2">
																<input name="gender_id"
																	   id="gender_id-<?php echo e($gender->tid); ?>"
																	   value="<?php echo e($gender->tid); ?>"
																	   class="form-check-input<?php echo e($genderIdError); ?>"
																	   type="radio" <?php echo e((old('gender_id', $user->gender_id)==$gender->tid) ? 'checked="checked"' : ''); ?>

																>
																<label class="form-check-label" for="gender_id-<?php echo e($gender->tid); ?>">
																	<?php echo e($gender->name); ?>

																</label>
															</div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php endif; ?>
												</div>
											</div>
												
											<!-- name -->
											<?php $nameError = (isset($errors) and $errors->has('name')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label"><?php echo e(t('Name')); ?> <sup>*</sup></label>
												<div class="col-md-9">
													<input name="name" type="text" class="form-control<?php echo e($nameError); ?>" placeholder="" value="<?php echo e(old('name', $user->name)); ?>">
												</div>
											</div>
											
											<!-- username -->
											<?php $usernameError = (isset($errors) and $errors->has('username')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label" for="email"><?php echo e(t('Username')); ?></label>
												<div class="input-group col-md-9">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="icon-user"></i></span>
													</div>
													
													<input id="username"
														   name="username"
														   type="text"
														   class="form-control<?php echo e($usernameError); ?>"
														   placeholder="<?php echo e(t('Username')); ?>"
														   value="<?php echo e(old('username', $user->username)); ?>"
													>
												</div>
											</div>
												
											<!-- email -->
											<?php $emailError = (isset($errors) and $errors->has('email')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label"><?php echo e(t('email')); ?>

													<?php if(!isEnabledField('phone')): ?>
														<sup>*</sup>
													<?php endif; ?>
												</label>
												<div class="input-group col-md-9">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="icon-mail"></i></span>
													</div>
													
													<input id="email"
														   name="email"
														   type="email"
														   class="form-control<?php echo e($emailError); ?>"
														   placeholder="<?php echo e(t('email')); ?>"
														   value="<?php echo e(old('email', $user->email)); ?>"
													>
												</div>
											</div>
                                                
                                            <!-- country_code -->
                                            <?php
                                            /*
                                            <?php $countryCodeError = (isset($errors) and $errors->has('country_code')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 control-label{{ $countryCodeError }}" for="country_code">
                                            		{{ t('your_country') }} <sup>*</sup>
                                            	</label>
												<div class="col-md-9">
													<select name="country_code" class="form-control sselecter{{ $countryCodeError }}">
														<option value="0" {{ (!old('country_code') or old('country_code')==0) ? 'selected="selected"' : '' }}>
															{{ t('select_a_country') }}
														</option>
														@foreach ($countries as $item)
															<option value="{{ $item->get('code') }}" {{ (old('country_code', $user->country_code)==$item->get('code')) ? 'selected="selected"' : '' }}>
																{{ $item->get('name') }}
															</option>
														@endforeach
													</select>
												</div>
											</div>
                                            */
                                            ?>
                                            <input name="country_code" type="hidden" value="<?php echo e($user->country_code); ?>">
												
											<!-- phone -->
											<?php $phoneError = (isset($errors) and $errors->has('phone')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label for="phone" class="col-md-3 col-form-label"><?php echo e(t('phone')); ?>

													<?php if(!isEnabledField('email')): ?>
														<sup>*</sup>
													<?php endif; ?>
												</label>
												<div class="input-group col-md-9">
													<div class="input-group-prepend">
														<span id="phoneCountry" class="input-group-text"><?php echo getPhoneIcon(old('country_code', $user->country_code)); ?></span>
													</div>
													
													<input id="phone" name="phone" type="text" class="form-control<?php echo e($phoneError); ?>"
														   placeholder="<?php echo e((!isEnabledField('email')) ? t('Mobile Phone Number') : t('phone_number')); ?>"
														   value="<?php echo e(phoneFormat(old('phone', $user->phone), old('country_code', $user->country_code))); ?>">
													
													<div class="input-group-append">
														<span class="input-group-text">
															<input name="phone_hidden" id="phoneHidden" type="checkbox"
																   value="1" <?php echo e((old('phone_hidden', $user->phone_hidden)=='1') ? 'checked="checked"' : ''); ?>>&nbsp;
															<small><?php echo e(t('Hide')); ?></small>
														</span>
													</div>
												</div>
											</div>

											<div class="form-group row">
												<div class="offset-md-3 col-md-9"></div>
											</div>
											
											<!-- Button -->
											<div class="form-group row">
												<div class="offset-md-3 col-md-9">
													<button type="submit" class="btn btn-primary"><?php echo e(t('Update')); ?></button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							
							<!-- SETTINGS -->
							<div class="card card-default">
								<div class="card-header">
									<h4 class="card-title"><a href="#settingsPanel" data-toggle="collapse" data-parent="#accordion"><?php echo e(t('Settings')); ?></a></h4>
								</div>
								<div class="panel-collapse collapse <?php echo e((old('panel')=='settingsPanel') ? 'show' : ''); ?>" id="settingsPanel">
									<div class="card-body">
										<form name="settings" class="form-horizontal" role="form" method="POST" action="<?php echo e(lurl('account/settings')); ?>">
											<?php echo csrf_field(); ?>

											<input name="_method" type="hidden" value="PUT">
											<input name="panel" type="hidden" value="settingsPanel">
										
											<?php if(config('settings.single.activation_facebook_comments') and config('services.facebook.client_id')): ?>
												<!-- disable_comments -->
												<div class="form-group row">
													<label class="col-md-3 col-form-label"></label>
													<div class="col-md-9">
														<div class="form-check form-check-inline pt-2">
															<label>
																<input id="disable_comments"
																	   name="disable_comments"
																	   value="1"
																	   type="checkbox" <?php echo e(($user->disable_comments==1) ? 'checked' : ''); ?>

																>
																<?php echo e(t('Disable comments on my ads')); ?>

															</label>
														</div>
													</div>
												</div>
											<?php endif; ?>
											
											<!-- password -->
											<?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
											<div class="form-group row">
												<label class="col-md-3 col-form-label"><?php echo e(t('New Password')); ?></label>
												<div class="col-md-9">
													<input id="password" name="password" type="password" class="form-control<?php echo e($passwordError); ?>" placeholder="<?php echo e(t('password')); ?>">
												</div>
											</div>
											
											<!-- password_confirmation -->
											<?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
											<div class="form-group row">
												<label class="col-md-3 col-form-label"><?php echo e(t('Confirm Password')); ?></label>
												<div class="col-md-9">
													<input id="password_confirmation" name="password_confirmation" type="password"
														   class="form-control<?php echo e($passwordError); ?>" placeholder="<?php echo e(t('Confirm Password')); ?>">
												</div>
											</div>
											
											<!-- Button -->
											<div class="form-group row">
												<div class="offset-md-3 col-md-9">
													<button type="submit" class="btn btn-primary"><?php echo e(t('Update')); ?></button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>

						</div>
						<!--/.row-box End-->

					</div>
				</div>
				<!--/.page-content-->
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
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
	</style>
	<style>
		/* Avatar Upload */
		.photo-field {
			display: inline-block;
			vertical-align: middle;
		}
		.photo-field .krajee-default.file-preview-frame,
		.photo-field .krajee-default.file-preview-frame:hover {
			margin: 0;
			padding: 0;
			border: none;
			box-shadow: none;
			text-align: center;
		}
		.photo-field .file-input {
			display: table-cell;
			width: 150px;
		}
		.photo-field .krajee-default.file-preview-frame .kv-file-content {
			width: 150px;
			height: 160px;
		}
		.kv-reqd {
			color: red;
			font-family: monospace;
			font-weight: normal;
		}
		
		.file-preview {
			padding: 2px;
		}
		.file-drop-zone {
			margin: 2px;
		}
		.file-drop-zone .file-preview-thumbnails {
			cursor: pointer;
		}
		
		.krajee-default.file-preview-frame .file-thumbnail-footer {
			height: 30px;
		}
	</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/fa/theme.js')); ?>" type="text/javascript"></script>
	<?php if(file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js')): ?>
		<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js')); ?>" type="text/javascript"></script>
	<?php endif; ?>
	<script>
		var photoInfo = '<h6 class="text-muted pb-0"><?php echo e(t('Click to select')); ?></h6>';
		var footerPreview = '<div class="file-thumbnail-footer pt-2">\n' +
			'    {actions}\n' +
			'</div>';
		
		$('#photoField').fileinput(
		{
			theme: "fa",
			language: '<?php echo e(config('app.locale')); ?>',
			<?php if(config('lang.direction') == 'rtl'): ?>
				rtl: true,
			<?php endif; ?>
			overwriteInitial: true,
			showCaption: false,
			showPreview: true,
			allowedFileExtensions: <?php echo getUploadFileTypes('image', true); ?>,
			uploadUrl: '<?php echo e(lurl('account/' . $user->id . '/photo')); ?>',
			uploadAsync: false,
			showBrowse: false,
			showCancel: true,
			showUpload: false,
			showRemove: false,
			minFileSize: <?php echo e((int)config('settings.upload.min_image_size', 0)); ?>, 
			maxFileSize: <?php echo e((int)config('settings.upload.max_image_size', 1000)); ?>, 
			browseOnZoneClick: true,
			minFileCount: 0,
			maxFileCount: 1,
			validateInitialCount: true,
			uploadClass: 'btn btn-primary',
			defaultPreviewContent: '<img src="<?php echo e(!empty($gravatar) ? $gravatar : url('images/user.jpg')); ?>" alt="<?php echo e(t('Your Photo or Avatar')); ?>">' + photoInfo,
			/* Retrieve current images */
			/* Setup initial preview with data keys */
			initialPreview: [
				<?php if(isset($user->photo) and !empty($user->photo)): ?>
					'<?php echo e(imgUrl($user->photo, 'user')); ?>'
				<?php endif; ?>
			],
			initialPreviewAsData: true,
			initialPreviewFileType: 'image',
			/* Initial preview configuration */
			initialPreviewConfig: [
				{
					<?php
						// Get the file size
						try {
							$fileSize = (isset($disk) && $disk->exists($user->photo)) ? (int)$disk->size($user->photo) : 0;
						} catch (\Exception $e) {
							$fileSize = 0;
						}
					?>
					<?php if(isset($user->photo) and !empty($user->photo)): ?>
						caption: '<?php echo e(last(explode('/', $user->photo))); ?>',
						size: <?php echo e($fileSize); ?>,
						url: '<?php echo e(lurl('account/' . $user->id . '/photo/delete')); ?>',
						key: <?php echo e((int)$user->id); ?>

					<?php endif; ?>
				}
			],
			
			showClose: false,
			fileActionSettings: {
				removeIcon: '<i class="far fa-trash-alt"></i>',
				removeClass: 'btn btn-sm btn-danger',
				removeTitle: '<?php echo e(t('Remove file')); ?>'
			},
			
			elErrorContainer: '#avatarUploadError',
			msgErrorClass: 'alert alert-block alert-danger',
			
			layoutTemplates: {main2: '{preview} {remove} {browse}', footer: footerPreview}
		});
		
		/* Auto-upload added file */
		$('#photoField').on('filebatchselected', function(event, data, id, index) {
			if (typeof data === 'object') {
				
				if (data.hasOwnProperty('0')) {
					$(this).fileinput('upload');
					return true;
				}
			}
			
			return false;
		});
		
		/* Show upload status message */
		$('#photoField').on('filebatchpreupload', function(event, data, id, index) {
			$('#avatarUploadSuccess').html('<ul></ul>').hide();
		});
		
		/* Show success upload message */
		$('#photoField').on('filebatchuploadsuccess', function(event, data, previewId, index) {
			/* Show uploads success messages */
			var out = '';
			$.each(data.files, function(key, file) {
				if (typeof file !== 'undefined') {
					var fname = file.name;
					out = out + <?php echo t('Uploaded file X successfully'); ?>;
				}
			});
			$('#avatarUploadSuccess ul').append(out);
			$('#avatarUploadSuccess').fadeIn('slow');
			
			$('#userImg').attr({'src':$('.photo-field .kv-file-content .file-preview-image').attr('src')});
		});
		
		/* Delete picture */
		$('#photoField').on('filepredelete', function(jqXHR) {
			var abort = true;
			if (confirm("<?php echo e(t('Are you sure you want to delete this picture')); ?>")) {
				abort = false;
			}
			return abort;
		});
		
		$('#photoField').on('filedeleted', function() {
			$('#userImg').attr({'src':'<?php echo !empty($gravatar) ? $gravatar : url('images/user.jpg'); ?>'});
			
			var out = "<?php echo e(t('Your photo or avatar has been deleted')); ?>";
			$('#avatarUploadSuccess').html('<ul><li></li></ul>').hide();
			$('#avatarUploadSuccess ul li').append(out);
			$('#avatarUploadSuccess').fadeIn('slow');
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/account/edit.blade.php ENDPATH**/ ?>