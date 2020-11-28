<?php if(isset($customFields) and $customFields->count() > 0): ?>
	<form id="cfForm" role="form" class="form" action="<?php echo e(request()->url()); ?>" method="GET">
		<?php echo csrf_field(); ?>

		<?php
		$disabledFieldsTypes = ['file', 'video'];
		$clearAll = '';
		$firstFieldFound = false;
		?>
		<?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if(in_array($field->type, $disabledFieldsTypes) or $field->use_as_filter != 1) continue; ?>
			<?php
			// Fields parameters
			$fieldId = 'cf.' . $field->tid;
			$fieldName = 'cf[' . $field->tid . ']';
			$fieldOld = 'cf.' . $field->tid;
			
			// Get the default value
			$defaultValue = (request()->filled($fieldOld)) ? request()->input($fieldOld) : $field->default;
			
			// Field Query String
			$fieldQueryString = '<input type="hidden" id="cf' . $field->tid . 'QueryString" value="' . httpBuildQuery(request()->except(['page', $fieldId])) . '">';
			
			// Clear All link
			if (request()->filled('cf')) {
				if (!$firstFieldFound) {
					$clearTitle = t('Clear all the category filters', ['category' => $cat->name]);
					$clearAll = '<a href="' . qsUrl(request()->url(), request()->except(['page', 'cf']), null, false) . '" title="' . $clearTitle . '">
									<span class="small" style="float: right;">' . t('Clear all') . '</span>
								</a>';
					$firstFieldFound = true;
				} else {
					$clearAll = '';
				}
			}
			?>
			
			<?php if(in_array($field->type, ['text', 'textarea', 'url', 'number'])): ?>
				
				<!-- text -->
				<div class="block-title has-arrow sidebar-header">
					<h5>
						<span class="font-weight-bold">
							<?php echo e($field->name); ?>

						</span> <?php echo $clearAll; ?>

					</h5>
				</div>
				<div class="block-content list-filter">
					<div class="filter-content row">
						<div class="form-group col-lg-9 col-md-12 col-sm-12">
							<input id="<?php echo e($fieldId); ?>"
								   name="<?php echo e($fieldName); ?>"
								   type="<?php echo e(($field->type == 'number') ? 'number' : 'text'); ?>"
								   placeholder="<?php echo e($field->name); ?>"
								   class="form-control input-md"
								   value="<?php echo e(strip_tags($defaultValue)); ?>"<?php echo ($field->type == 'number') ? ' autocomplete="off"' : ''; ?>

							>
						</div>
						<div class="form-group col-lg-3 col-md-12 col-sm-12">
							<button class="btn btn-default pull-right btn-block-md btn-block-xs" type="submit"><?php echo e(t('go')); ?></button>
						</div>
					</div>
				</div>
				<?php echo $fieldQueryString; ?>

				<div style="clear:both"></div>
			
			<?php endif; ?>
			<?php if($field->type == 'checkbox'): ?>
				
				<!-- checkbox -->
				<div class="block-title has-arrow sidebar-header">
					<h5>
						<span class="font-weight-bold"><a href="#"><?php echo e($field->name); ?></a></span> <?php echo $clearAll; ?>

					</h5>
				</div>
				<div class="block-content list-filter">
					<div class="filter-content">
						<div class="form-check">
							<input id="<?php echo e($fieldId); ?>"
								   name="<?php echo e($fieldName); ?>"
								   value="1"
								   type="checkbox"
								   class="form-check-input"
									<?php echo e(($defaultValue == '1') ? 'checked="checked"' : ''); ?>

							>
							<label class="form-check-label" for="<?php echo e($fieldId); ?>">
								<?php echo e($field->name); ?>

							</label>
						</div>
					</div>
				</div>
				<?php echo $fieldQueryString; ?>

				<div style="clear:both"></div>
			
			<?php endif; ?>
			<?php if($field->type == 'checkbox_multiple'): ?>
				
				<?php if($field->options->count() > 0): ?>
					<!-- checkbox_multiple -->
					<div class="block-title has-arrow sidebar-header">
						<h5>
							<span class="font-weight-bold">
								<?php echo e($field->name); ?>

							</span> <?php echo $clearAll; ?>

						</h5>
					</div>
					<div class="block-content list-filter">
						<?php $cmFieldStyle = ($field->options->count() > 12) ? ' style="height: 250px; overflow-y: scroll;"' : ''; ?>
						<div class="filter-content"<?php echo $cmFieldStyle; ?>>
							<?php $__currentLoopData = $field->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
								// Get the default value
								$defaultValue = (request()->filled($fieldOld . '.' . $option->tid))
									? request()->input($fieldOld . '.' . $option->tid)
									: (
										(is_array($field->default) && isset($field->default[$option->tid], $field->default[$option->tid]->value))
											? $field->default[$option->tid]->value
											: $field->default
									);
								
								// Field Query String
								$fieldQueryString = '<input type="hidden" id="cf' . $field->tid . $option->tid . 'QueryString"
									value="' . httpBuildQuery(request()->except(['page', $fieldId . '.' . $option->tid])) . '">';
								?>
								<div class="form-check">
									<input id="<?php echo e($fieldId . '.' . $option->tid); ?>"
										   name="<?php echo e($fieldName . '[' . $option->tid . ']'); ?>"
										   value="<?php echo e($option->tid); ?>"
										   type="checkbox"
										   class="form-check-input"
											<?php echo e(($defaultValue == $option->tid) ? 'checked="checked"' : ''); ?>

									>
									<label class="form-check-label" for="<?php echo e($fieldId . '.' . $option->tid); ?>">
										<?php echo e($option->value); ?>

									</label>
								</div>
								<?php echo $fieldQueryString; ?>

							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
					<div style="clear:both"></div>
				<?php endif; ?>
			
			<?php endif; ?>
			<?php if($field->type == 'radio'): ?>
				
				<?php if($field->options->count() > 0): ?>
					<!-- radio -->
					<div class="block-title has-arrow sidebar-header">
						<h5>
							<span class="font-weight-bold">
								<?php echo e($field->name); ?>

							</span> <?php echo $clearAll; ?>

						</h5>
					</div>
					<div class="block-content list-filter">
						<?php $rFieldStyle = ($field->options->count() > 12) ? ' style="height: 250px; overflow-y: scroll;"' : ''; ?>
						<div class="filter-content"<?php echo $rFieldStyle; ?>>
							<?php $__currentLoopData = $field->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="form-check">
									<input id="<?php echo e($fieldId); ?>"
										   name="<?php echo e($fieldName); ?>"
										   value="<?php echo e($option->tid); ?>"
										   type="radio"
										   class="form-check-input"
											<?php echo e(($defaultValue == $option->tid) ? 'checked="checked"' : ''); ?>

									>
									<label class="form-check-label" for="<?php echo e($fieldId); ?>">
										<?php echo e($option->value); ?>

									</label>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
					<?php echo $fieldQueryString; ?>

					<div style="clear:both"></div>
				<?php endif; ?>
				
			<?php endif; ?>
			<?php if($field->type == 'select'): ?>
			
				<!-- select -->
				<div class="block-title has-arrow sidebar-header">
					<h5>
						<span class="font-weight-bold">
							<?php echo e($field->name); ?>

						</span> <?php echo $clearAll; ?>

					</h5>
				</div>
				<div class="block-content list-filter">
					<div class="filter-content">
						<?php
							$select2Type = ($field->options->count() <= 10) ? 'selecter' : 'sselecter';
						?>
						<select id="<?php echo e($fieldId); ?>" name="<?php echo e($fieldName); ?>" class="form-control <?php echo e($select2Type); ?>">
							<option value=""
									<?php if(old($fieldOld) == '' or old($fieldOld) == 0): ?>
										selected="selected"
									<?php endif; ?>
							>
								<?php echo e(t('Select')); ?>

							</option>
							<?php if($field->options->count() > 0): ?>
								<?php $__currentLoopData = $field->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($option->tid); ?>"
											<?php if($defaultValue == $option->tid): ?>
												selected="selected"
											<?php endif; ?>
									>
										<?php echo e($option->value); ?>

									</option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
				</div>
				<?php echo $fieldQueryString; ?>

				<div style="clear:both"></div>
			
			<?php endif; ?>
			<?php if(in_array($field->type, ['date', 'date_time', 'date_range'])): ?>
			
				<!-- date -->
				<div class="block-title has-arrow sidebar-header">
					<h5>
						<span class="font-weight-bold">
							<?php echo e($field->name); ?>

						</span> <?php echo $clearAll; ?>

					</h5>
				</div>
				<?php
				$datePickerClass = '';
				if (in_array($field->type, ['date', 'date_time'])) {
					$datePickerClass = ' cf-date';
				}
				if ($field->type == 'date_range') {
					$datePickerClass = ' cf-date_range';
				}
				?>
				<div class="block-content list-filter">
					<div class="filter-content row">
						<div class="form-group col-lg-9 col-md-12 col-sm-12">
							<input id="<?php echo e($fieldId); ?>"
								   name="<?php echo e($fieldName); ?>"
								   type="text"
								   placeholder="<?php echo e($field->name); ?>"
								   class="form-control input-md<?php echo e($datePickerClass); ?>"
								   value="<?php echo e(strip_tags($defaultValue)); ?>"
								   autocomplete="off"
							>
						</div>
						<div class="form-group col-lg-3 col-md-12 col-sm-12">
							<button class="btn btn-default pull-right btn-block-md btn-block-xs" type="submit"><?php echo e(t('go')); ?></button>
						</div>
					</div>
				</div>
				<?php echo $fieldQueryString; ?>

				<div style="clear:both"></div>
			
			<?php endif; ?>
			
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</form>
	<div style="clear:both"></div>
<?php endif; ?>

<?php $__env->startSection('after_styles'); ?>
	<link href="<?php echo e(url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('after_scripts'); ?>
	##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
	<script src="<?php echo e(url('assets/plugins/momentjs/moment.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')); ?>" type="text/javascript"></script>
	<script>
		$(document).ready(function ()
		{
			/* Select */
			$('#cfForm').find('select').change(function() {
				/* Get full field's ID */
				var fullFieldId = $(this).attr('id');
				
				/* Get full field's ID without dots */
				var jsFullFieldId = fullFieldId.split('.').join('');
				
				/* Get real field's ID */
				var tmp = fullFieldId.split('.');
				if (typeof tmp[1] !== 'undefined') {
					var fieldId = tmp[1];
				} else {
					return false;
				}
				
				/* Get saved QueryString */
				var fieldQueryString = $('#' + jsFullFieldId + 'QueryString').val();
				
				/* Add the field's value to the QueryString */
				if (fieldQueryString !== '') {
					fieldQueryString = fieldQueryString + '&';
				}
				fieldQueryString = fieldQueryString + 'cf['+fieldId+']=' + $(this).val();
				
				/* Redirect to the new search URL */
				var searchUrl = baseUrl + '?' + fieldQueryString;
				redirect(searchUrl);
			});
			
			/* Radio & Checkbox */
			$('#cfForm').find('input[type=radio], input[type=checkbox]').click(function() {
				/* Get full field's ID */
				var fullFieldId = $(this).attr('id');
				
				/* Get full field's ID without dots */
				var jsFullFieldId = fullFieldId.split('.').join('');
				
				/* Get real field's ID */
				var tmp = fullFieldId.split('.');
				if (typeof tmp[1] !== 'undefined') {
					var fieldId = tmp[1];
					if (typeof tmp[2] !== 'undefined') {
						var fieldOptionId = tmp[2];
					}
				} else {
					return false;
				}
				
				/* Get saved QueryString */
				var fieldQueryString = $('#' + jsFullFieldId + 'QueryString').val();
				
				/* Check if field is checked */
				if ($(this).prop('checked') == true) {
					/* Add the field's value to the QueryString */
					if (fieldQueryString != '') {
						fieldQueryString = fieldQueryString + '&';
					}
					if (typeof fieldOptionId !== 'undefined') {
						fieldQueryString = fieldQueryString + 'cf[' + fieldId + '][' + fieldOptionId + ']=' + rawurlencode($(this).val());
					} else {
						fieldQueryString = fieldQueryString + 'cf[' + fieldId + ']=' + $(this).val();
					}
				}
				
				/* Redirect to the new search URL */
				var searchUrl = baseUrl + '?' + fieldQueryString;
				redirect(searchUrl);
			});
			
			/*
			 * Custom Fields Date Picker
			 * https://www.daterangepicker.com/#options
			 */
			
			$('#cfForm .cf-date').daterangepicker({
				autoUpdateInput: false,
				autoApply: true,
				showDropdowns: true,
				minYear: parseInt(moment().format('YYYY')) - 100,
				maxYear: parseInt(moment().format('YYYY')) + 20,
				locale: {
					format: '<?php echo e(t('datepicker_format')); ?>',
					applyLabel: "<?php echo e(t('datepicker_applyLabel')); ?>",
					cancelLabel: "<?php echo e(t('datepicker_cancelLabel')); ?>",
					fromLabel: "<?php echo e(t('datepicker_fromLabel')); ?>",
					toLabel: "<?php echo e(t('datepicker_toLabel')); ?>",
					customRangeLabel: "<?php echo e(t('datepicker_customRangeLabel')); ?>",
					weekLabel: "<?php echo e(t('datepicker_weekLabel')); ?>",
					daysOfWeek: [
						"<?php echo e(t('datepicker_sunday')); ?>",
						"<?php echo e(t('datepicker_monday')); ?>",
						"<?php echo e(t('datepicker_tuesday')); ?>",
						"<?php echo e(t('datepicker_wednesday')); ?>",
						"<?php echo e(t('datepicker_thursday')); ?>",
						"<?php echo e(t('datepicker_friday')); ?>",
						"<?php echo e(t('datepicker_saturday')); ?>"
					],
					monthNames: [
						"<?php echo e(t('January')); ?>",
						"<?php echo e(t('February')); ?>",
						"<?php echo e(t('March')); ?>",
						"<?php echo e(t('April')); ?>",
						"<?php echo e(t('May')); ?>",
						"<?php echo e(t('June')); ?>",
						"<?php echo e(t('July')); ?>",
						"<?php echo e(t('August')); ?>",
						"<?php echo e(t('September')); ?>",
						"<?php echo e(t('October')); ?>",
						"<?php echo e(t('November')); ?>",
						"<?php echo e(t('December')); ?>"
					],
					firstDay: 1
				},
				singleDatePicker: true,
				startDate: moment().format('<?php echo e(t('datepicker_format')); ?>')
			});
			$('#cfForm .cf-date').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format')); ?>'));
			});
			
			
			$('#cfForm .cf-date_range').daterangepicker({
				autoUpdateInput: false,
				autoApply: true,
				showDropdowns: false,
				minYear: parseInt(moment().format('YYYY')) - 100,
				maxYear: parseInt(moment().format('YYYY')) + 20,
				locale: {
					format: '<?php echo e(t('datepicker_format')); ?>',
					applyLabel: "<?php echo e(t('datepicker_applyLabel')); ?>",
					cancelLabel: "<?php echo e(t('datepicker_cancelLabel')); ?>",
					fromLabel: "<?php echo e(t('datepicker_fromLabel')); ?>",
					toLabel: "<?php echo e(t('datepicker_toLabel')); ?>",
					customRangeLabel: "<?php echo e(t('datepicker_customRangeLabel')); ?>",
					weekLabel: "<?php echo e(t('datepicker_weekLabel')); ?>",
					daysOfWeek: [
						"<?php echo e(t('datepicker_sunday')); ?>",
						"<?php echo e(t('datepicker_monday')); ?>",
						"<?php echo e(t('datepicker_tuesday')); ?>",
						"<?php echo e(t('datepicker_wednesday')); ?>",
						"<?php echo e(t('datepicker_thursday')); ?>",
						"<?php echo e(t('datepicker_friday')); ?>",
						"<?php echo e(t('datepicker_saturday')); ?>"
					],
					monthNames: [
						"<?php echo e(t('January')); ?>",
						"<?php echo e(t('February')); ?>",
						"<?php echo e(t('March')); ?>",
						"<?php echo e(t('April')); ?>",
						"<?php echo e(t('May')); ?>",
						"<?php echo e(t('June')); ?>",
						"<?php echo e(t('July')); ?>",
						"<?php echo e(t('August')); ?>",
						"<?php echo e(t('September')); ?>",
						"<?php echo e(t('October')); ?>",
						"<?php echo e(t('November')); ?>",
						"<?php echo e(t('December')); ?>"
					],
					firstDay: 1
				},
				startDate: moment().format('<?php echo e(t('datepicker_format')); ?>'),
				endDate: moment().add(1, 'days').format('<?php echo e(t('datepicker_format')); ?>')
			});
			$('#cfForm .cf-date_range').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format')); ?>') + ' - ' + picker.endDate.format('<?php echo e(t('datepicker_format')); ?>'));
			});
		});
	</script>
<?php $__env->stopSection(); ?><?php /**PATH /home/developer/public_html/resources/views/search/inc/sidebar/fields.blade.php ENDPATH**/ ?>