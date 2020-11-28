<?php $__env->startSection('wizard'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.createOrEdit.multiSteps.inc.wizard', 'post.createOrEdit.multiSteps.inc.wizard'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.inc.notification', 'post.inc.notification'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2">
							<strong><i class="icon-docs"></i> <?php echo e(t('post_free_ads')); ?></strong>
						</h2>
						
						<div class="row">
							<div class="col-xl-12">
								
								<form class="form-horizontal" id="postForm" method="POST" action="<?php echo e(request()->fullUrl()); ?>" enctype="multipart/form-data">
									<?php echo csrf_field(); ?>

									<fieldset>

										<!-- category_id -->
										<?php $categoryIdError = (isset($errors) and $errors->has('category_id')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label<?php echo e($categoryIdError); ?>"><?php echo e(t('category')); ?> <sup>*</sup></label>
											<div class="col-md-8">
												<div id="catsContainer" class="rounded">
													<a href="#browseCategories" data-toggle="modal" class="cat-link" data-id="0">
														<?php echo e(t('select_a_category')); ?>

													</a>
												</div>
											</div>
											<input type="hidden" name="category_id" id="categoryId" value="<?php echo e(old('category_id', 0)); ?>">
											<input type="hidden" name="category_type" id="categoryType" value="<?php echo e(old('category_type')); ?>">
										</div>
										
										<!-- post_type_id -->
										<?php $postTypeIdError = (isset($errors) and $errors->has('post_type_id')) ? ' is-invalid' : ''; ?>
										<div id="postTypeBloc" class="form-group row required">
											<label class="col-md-3 col-form-label"><?php echo e(t('type')); ?> <sup>*</sup></label>
											<div class="col-md-8">
												<?php $__currentLoopData = $postTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<div class="form-check form-check-inline pt-2">
													<input name="post_type_id"
														   id="postTypeId-<?php echo e($postType->tid); ?>"
														   value="<?php echo e($postType->tid); ?>"
														   type="radio"
														   class="form-check-input<?php echo e($postTypeIdError); ?>" <?php echo e((old('post_type_id')==$postType->tid) ? 'checked="checked"' : ''); ?>

													>
													<label class="form-check-label" for="postTypeId-<?php echo e($postType->tid); ?>">
														<?php echo e($postType->name); ?>

													</label>
												</div>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												<small id="" class="form-text text-muted"><?php echo e(t('post_type_hint')); ?></small>
											</div>
										</div>

										<!-- title -->
										<?php $titleError = (isset($errors) and $errors->has('title')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="title"><?php echo e(t('title')); ?> <sup>*</sup></label>
											<div class="col-md-8">
												<input id="title" name="title" placeholder="<?php echo e(t('ad_title')); ?>" class="form-control input-md<?php echo e($titleError); ?>"
													   type="text" value="<?php echo e(old('title')); ?>">
												<small id="" class="form-text text-muted"><?php echo e(t('a_great_title_needs_at_least_60_characters')); ?></small>
											</div>
										</div>

										<!-- description -->
										<?php $descriptionError = (isset($errors) and $errors->has('description')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<?php
												$descriptionErrorLabel = '';
												$descriptionColClass = 'col-md-8';
												if (config('settings.single.wysiwyg_editor') != 'none') {
													$descriptionColClass = 'col-md-12';
													$descriptionErrorLabel = $descriptionError;
												}
											?>
											<label class="col-md-3 col-form-label<?php echo e($descriptionErrorLabel); ?>" for="description">
												<?php echo e(t('Description')); ?> <sup>*</sup>
											</label>
											<div class="<?php echo e($descriptionColClass); ?>">
												<textarea class="form-control<?php echo e($descriptionError); ?>"
														  id="description"
														  name="description"
														  rows="15"
												><?php echo e(old('description')); ?></textarea>
												<small id="" class="form-text text-muted"><?php echo e(t('describe_what_makes_your_ad_unique')); ?>...</small>
											</div>
										</div>
										
										<!-- cfContainer -->
										<div id="cfContainer"></div>

										<!-- price -->
										<?php $priceError = (isset($errors) and $errors->has('price')) ? ' is-invalid' : ''; ?>
										<div id="priceBloc" class="form-group row">
											<label class="col-md-3 col-form-label" for="price"><?php echo e(t('price')); ?></label>
											<div class="input-group col-md-8">
												<div class="input-group-prepend">
													<span class="input-group-text"><?php echo config('currency')['symbol']; ?></span>
												</div>
												<?php
												$price = \App\Helpers\Number::format(
													old('price'),
													(int)config('currency.decimal_places', 2),
													config('currency.decimal_separator', '.'),
													config('currency.thousand_separator', ','),
													true
												);
												?>
												<input id="price"
													   name="price"
													   class="form-control<?php echo e($priceError); ?>"
													   placeholder="<?php echo e(t('ei_price')); ?>"
													   type="text" value="<?php echo $price; ?>"
												>
												
												<div class="input-group-append">
													<span class="input-group-text">
														<input id="negotiable" name="negotiable" type="checkbox"
															   value="1" <?php echo e((old('negotiable')=='1') ? 'checked="checked"' : ''); ?>>&nbsp;<small><?php echo e(t('negotiable')); ?></small>
													</span>
												</div>
											</div>
										</div>
										
										<!-- country_code -->
										<?php $countryCodeError = (isset($errors) and $errors->has('country_code')) ? ' is-invalid' : ''; ?>
										<?php if(empty(config('country.code'))): ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label<?php echo e($countryCodeError); ?>" for="country_code"><?php echo e(t('your_country')); ?> <sup>*</sup></label>
												<div class="col-md-8">
													<select id="countryCode" name="country_code" class="form-control sselecter<?php echo e($countryCodeError); ?>">
														<option value="0" <?php echo e((!old('country_code') or old('country_code')==0) ? 'selected="selected"' : ''); ?>> <?php echo e(t('select_a_country')); ?> </option>
														<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($item->get('code')); ?>" <?php echo e((old('country_code', (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0)==$item->get('code')) ? 'selected="selected"' : ''); ?>><?php echo e($item->get('name')); ?></option>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</select>
												</div>
											</div>
										<?php else: ?>
											<input id="countryCode" name="country_code" type="hidden" value="<?php echo e(config('country.code')); ?>">
										<?php endif; ?>
										
										<?php
										/*
										@if (\Illuminate\Support\Facades\Schema::hasColumn('posts', 'address'))
										<!-- address -->
										<div class="form-group required <?php echo ($errors->has('address')) ? ' is-invalid' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Address') }} </label>
											<div class="col-md-8">
												<input id="address" name="address" placeholder="{{ t('Address') }}" class="form-control input-md"
													   type="text" value="{{ old('address') }}">
												<span class="help-block">{{ t('Fill an address to display on Google Maps') }} </span>
											</div>
										</div>
										@endif
										*/
										?>
										
										<?php if(config('country.admin_field_active') == 1 and in_array(config('country.admin_type'), ['1', '2'])): ?>
											<!-- admin_code -->
											<?php $adminCodeError = (isset($errors) and $errors->has('admin_code')) ? ' is-invalid' : ''; ?>
											<div id="locationBox" class="form-group row required">
												<label class="col-md-3 col-form-label<?php echo e($adminCodeError); ?>" for="admin_code"><?php echo e(t('Location')); ?> <sup>*</sup></label>
												<div class="col-md-8">
													<select id="adminCode" name="admin_code" class="form-control sselecter<?php echo e($adminCodeError); ?>">
														<option value="0" <?php echo e((!old('admin_code') or old('admin_code')==0) ? 'selected="selected"' : ''); ?>>
															<?php echo e(t('select_your_location')); ?>

														</option>
													</select>
												</div>
											</div>
										<?php endif; ?>
									
										<!-- city_id -->
										<?php $cityIdError = (isset($errors) and $errors->has('city_id')) ? ' is-invalid' : ''; ?>
										<div id="cityBox" class="form-group row required">
											<label class="col-md-3 col-form-label<?php echo e($cityIdError); ?>" for="city_id"><?php echo e(t('city')); ?> <sup>*</sup></label>
											<div class="col-md-8">
												<select id="cityId" name="city_id" class="form-control sselecter<?php echo e($cityIdError); ?>">
													<option value="0" <?php echo e((!old('city_id') or old('city_id')==0) ? 'selected="selected"' : ''); ?>>
														<?php echo e(t('select_a_city')); ?>

													</option>
												</select>
											</div>
										</div>
										
										<!-- tags -->
										<?php $tagsError = (isset($errors) and $errors->has('tags')) ? ' is-invalid' : ''; ?>
										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="tags"><?php echo e(t('Tags')); ?></label>
											<div class="col-md-8">
												<input id="tags"
													   name="tags"
													   placeholder="<?php echo e(t('Tags')); ?>"
													   class="form-control input-md<?php echo e($tagsError); ?>"
													   type="text"
													   value="<?php echo e(old('tags')); ?>"
												>
												<small id="" class="form-text text-muted"><?php echo e(t('Enter the tags separated by commas')); ?></small>
											</div>
										</div>
										
										<!-- is_permanent -->
										<?php if(config('settings.single.permanent_posts_enabled') == '3'): ?>
											<input type="hidden" name="is_permanent" id="isPermanent" value="0">
										<?php else: ?>
											<?php $isPermanentError = (isset($errors) and $errors->has('is_permanent')) ? ' is-invalid' : ''; ?>
											<div id="isPermanentBox" class="form-group row required hide">
												<label class="col-md-3 col-form-label"></label>
												<div class="col-md-8">
													<div class="form-check">
														<input name="is_permanent" id="isPermanent"
															   class="form-check-input mt-1<?php echo e($isPermanentError); ?>"
															   value="1"
															   type="checkbox" <?php echo e((old('is_permanent')=='1') ? 'checked="checked"' : ''); ?>

														>
														<label class="form-check-label mt-0" for="is_permanent">
															<?php echo t('is_permanent_label'); ?>

														</label>
													</div>
													<small id="" class="form-text text-muted"><?php echo e(t('is_permanent_hint')); ?></small>
													<div style="clear:both"></div>
												</div>
											</div>
										<?php endif; ?>
										
										
										<div class="content-subheading">
											<i class="icon-user fa"></i>
											<strong><?php echo e(t('seller_information')); ?></strong>
										</div>
										
										
										<!-- contact_name -->
										<?php $contactNameError = (isset($errors) and $errors->has('contact_name')) ? ' is-invalid' : ''; ?>
										<?php if(auth()->check()): ?>
											<input id="contact_name" name="contact_name" type="hidden" value="<?php echo e(auth()->user()->name); ?>">
										<?php else: ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label" for="contact_name"><?php echo e(t('your_name')); ?> <sup>*</sup></label>
												<div class="col-md-8">
													<input id="contact_name" name="contact_name" placeholder="<?php echo e(t('your_name')); ?>"
														   class="form-control input-md<?php echo e($contactNameError); ?>" type="text" value="<?php echo e(old('contact_name')); ?>">
												</div>
											</div>
										<?php endif; ?>
										
										<?php
											if (auth()->check()) {
												$formPhone = (auth()->user()->country_code == config('country.code')) ? auth()->user()->phone : '';
											} else {
												$formPhone = '';
											}
										?>
										<!-- phone -->
										<?php $phoneError = (isset($errors) and $errors->has('phone')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="phone"><?php echo e(t('phone_number')); ?>

												<?php if(!isEnabledField('email')): ?>
													<sup>*</sup>
												<?php endif; ?>
											</label>
											<div class="input-group col-md-8">
												<div class="input-group-prepend">
													<span id="phoneCountry" class="input-group-text"><?php echo getPhoneIcon(config('country.code')); ?></span>
												</div>
												
												<input id="phone" name="phone"
													   placeholder="<?php echo e(t('phone_number')); ?>"
													   class="form-control input-md<?php echo e($phoneError); ?>" type="text"
													   value="<?php echo e(phoneFormat(old('phone', $formPhone), old('country', config('country.code')))); ?>"
												>
												
												<div class="input-group-append">
													<span class="input-group-text">
														<input name="phone_hidden" id="phoneHidden" type="checkbox"
															   value="1" <?php echo e((old('phone_hidden')=='1') ? 'checked="checked"' : ''); ?>>&nbsp;<small><?php echo e(t('Hide')); ?></small>
													</span>
												</div>
											</div>
										</div>
										
										<!-- email -->
										<?php $emailError = (isset($errors) and $errors->has('email')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="email"><?php echo e(t('email')); ?>

												<?php if(!isEnabledField('phone') or !auth()->check()): ?>
													<sup>*</sup>
												<?php endif; ?>
											</label>
											<div class="input-group col-md-8">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="icon-mail"></i></span>
												</div>
												
												<input id="email" name="email"
													   class="form-control<?php echo e($emailError); ?>" placeholder="<?php echo e(t('email')); ?>" type="text"
													   value="<?php echo e(old('email', ((auth()->check() and isset(auth()->user()->email)) ? auth()->user()->email : ''))); ?>">
											</div>
										</div>
										
										<?php if(!auth()->check()): ?>
											<?php if(in_array(config('settings.single.auto_registration'), [1, 2])): ?>
												<!-- auto_registration -->
												<?php if(config('settings.single.auto_registration') == 1): ?>
													<?php $autoRegistrationError = (isset($errors) and $errors->has('auto_registration')) ? ' is-invalid' : ''; ?>
													<div class="form-group row required">
														<label class="col-md-3 col-form-label"></label>
														<div class="col-md-8">
															<div class="form-check">
																<input name="auto_registration" id="auto_registration"
																	   class="form-check-input<?php echo e($autoRegistrationError); ?>"
																	   value="1"
																	   type="checkbox"
																	   checked="checked"
																>
																
																<label class="form-check-label" for="auto_registration">
																	<?php echo t('I want to register by submitting this ad'); ?>

																</label>
															</div>
															<small id="" class="form-text text-muted"><?php echo e(t('You will receive your authentication information by email')); ?></small>
															<div style="clear:both"></div>
														</div>
													</div>
												<?php else: ?>
													<input type="hidden" name="auto_registration" id="auto_registration" value="1">
												<?php endif; ?>
											<?php endif; ?>
										<?php endif; ?>
										
										<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.recaptcha', 'layouts.inc.tools.recaptcha'], ['colLeft' => 'col-md-3', 'colRight' => 'col-md-8'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

										<!-- term -->
										<?php $termError = (isset($errors) and $errors->has('term')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label<?php echo e($termError); ?>"></label>
											<div class="col-md-8">
												<label class="checkbox mb-0" for="term-0">
													<?php echo t('by_continuing_on_this_website_you_accept_our_terms_of_use', ['attributes' => getUrlPageByType('terms')]); ?>

												</label>
											</div>
										</div>

										<!-- Button  -->
										<div class="form-group row pt-3">
											<div class="col-md-12 text-center">
												<button id="nextStepBtn" class="btn btn-primary btn-lg"> <?php echo e(t('submit')); ?> </button>
											</div>
										</div>

									</fieldset>
								</form>

							</div>
						</div>
					</div>
				</div>
				<!-- /.page-content -->

				<div class="col-md-3 reg-sidebar">
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.right-sidebar', 'post.createOrEdit.inc.right-sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
				
			</div>
		</div>
	</div>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.category-modal', 'post.createOrEdit.inc.category-modal'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.form-assets', 'post.createOrEdit.inc.form-assets'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/post/createOrEdit/multiSteps/create.blade.php ENDPATH**/ ?>