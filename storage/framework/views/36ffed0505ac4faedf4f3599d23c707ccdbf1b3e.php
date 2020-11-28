<?php
	if (!isset($languageCode) or empty($languageCode)) {
		$languageCode = config('app.locale', session('language_code'));
	}
?>
<?php if(isset($fields) and $fields->count() > 0): ?>
	<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
		// Fields parameters
		$fieldId = 'cf.' . $field->tid;
        $fieldName = 'cf[' . $field->tid . ']';
		$fieldOld = 'cf.' . $field->tid;
        
        // Errors & Required CSS
        $requiredClass = ($field->required == 1) ? 'required' : '';
        $errorClass = (isset($errors) && $errors->has($fieldOld)) ? ' is-invalid' : '';
        
        // Get the default value
        $defaultValue = (isset($oldInput) && isset($oldInput[$field->tid])) ? $oldInput[$field->tid] : $field->default;
		?>
		
		<?php if($field->type == 'checkbox'): ?>
			
			<!-- checkbox -->
			<div class="form-group row <?php echo e($requiredClass); ?>" style="margin-top: -10px;">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>"></label>
				<div class="col-md-8">
					<div class="form-check pt-2">
						<input id="<?php echo e($fieldId); ?>"
							   name="<?php echo e($fieldName); ?>"
							   value="1"
							   type="checkbox"
							   class="form-check-input<?php echo e($errorClass); ?>"
								<?php echo e(($defaultValue=='1') ? 'checked="checked"' : ''); ?>

						>
						<label class="form-check-label" for="<?php echo e($fieldId); ?>">
							<?php echo e($field->name); ?>

						</label>
					</div>
					<small id="" class="form-text text-muted"><?php echo $field->help; ?></small>
				</div>
			</div>
		
		<?php elseif($field->type == 'checkbox_multiple'): ?>
			
			<?php if($field->options->count() > 0): ?>
				<!-- checkbox_multiple -->
				<div class="form-group row <?php echo e($requiredClass); ?>" style="margin-top: -10px;">
					<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
						<?php echo e($field->name); ?>

						<?php if($field->required == 1): ?>
							<sup>*</sup>
						<?php endif; ?>
					</label>
					<?php $cmFieldStyle = ($field->options->count() > 12) ? ' style="height: 250px; overflow-y: scroll;"' : ''; ?>
					<div class="col-md-8"<?php echo $cmFieldStyle; ?>>
						<?php $__currentLoopData = $field->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
							// Get the default value
							$defaultValue = (isset($oldInput) && isset($oldInput[$field->tid]) && isset($oldInput[$field->tid][$option->tid]))
								? $oldInput[$field->tid][$option->tid]
								: (
								(is_array($field->default) && isset($field->default[$option->tid]) && isset($field->default[$option->tid]->tid))
									? $field->default[$option->tid]->tid
									: $field->default
								);
							?>
							<div class="form-check pt-2">
								<input id="<?php echo e($fieldId . '.' . $option->tid); ?>"
									   name="<?php echo e($fieldName . '[' . $option->tid . ']'); ?>"
									   value="<?php echo e($option->tid); ?>"
									   type="checkbox"
									   class="form-check-input<?php echo e($errorClass); ?>"
										<?php echo e(($defaultValue==$option->tid) ? 'checked="checked"' : ''); ?>

								>
								<label class="form-check-label" for="<?php echo e($fieldId . '.' . $option->tid); ?>">
									 <?php echo e($option->value); ?>

								</label>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<small id="" class="form-text text-muted"><?php echo $field->help; ?></small>
					</div>
				</div>
			<?php endif; ?>
			
		<?php elseif($field->type == 'file'): ?>
			
			<!-- file -->
			<div class="form-group row <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e($field->name); ?>

					<?php if($field->required == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<div class="mb10">
						<input id="<?php echo e($fieldId); ?>" name="<?php echo e($fieldName); ?>" type="file" class="file<?php echo e($errorClass); ?>">
					</div>
					<small id="" class="form-text text-muted">
						<?php echo $field->help; ?> <?php echo e(t('file_types', ['file_types' => showValidFileTypes('file')], 'global', $languageCode)); ?>

					</small>
					<?php if(!empty($field->default) and $disk->exists($field->default)): ?>
						<div>
							<a class="btn btn-default" href="<?php echo e(fileUrl($field->default)); ?>" target="_blank">
								<i class="icon-attach-2"></i> <?php echo e(t('Download')); ?>

							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		
		<?php elseif($field->type == 'radio'): ?>
			
			<?php if($field->options->count() > 0): ?>
				<!-- radio -->
				<div class="form-group row <?php echo e($requiredClass); ?>">
					<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
						<?php echo e($field->name); ?>

						<?php if($field->required == 1): ?>
							<sup>*</sup>
						<?php endif; ?>
					</label>
					<div class="col-md-8">
						<?php $__currentLoopData = $field->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="form-check pt-2">
								<input id="<?php echo e($fieldId); ?>"
									   name="<?php echo e($fieldName); ?>"
									   value="<?php echo e($option->tid); ?>"
									   type="radio"
									   class="form-check-input<?php echo e($errorClass); ?>"
										<?php echo e(($defaultValue==$option->tid) ? 'checked="checked"' : ''); ?>

								>
								<label class="form-check-label" for="<?php echo e($fieldName); ?>">
									<?php echo e($option->value); ?>

								</label>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<small id="" class="form-text text-muted"><?php echo $field->help; ?></small>
				</div>
			<?php endif; ?>
		
		<?php elseif($field->type == 'select'): ?>
			<!-- select -->
			<div class="form-group row <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label<?php echo e($errorClass); ?>" for="<?php echo e($fieldId); ?>">
					<?php echo e($field->name); ?>

					<?php if($field->required == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8 <?php echo e($field->name); ?>-123">
                    <?php
                    	$select2Type = ($field->options->count() <= 10) ? 'selecter' : 'sselecter';
                    ?>
					<select id="<?php echo e($fieldId); ?>" name="<?php echo e($fieldName); ?>" class="form-control <?php echo e($select2Type . $errorClass); ?> <?php echo e(strtolower($field->name).'_forsubfields'); ?>">
						<option value="<?php echo e($field->default); ?>"
								<?php if(old($fieldOld)=='' or old($fieldOld)==$field->default): ?>
									selected="selected"
								<?php endif; ?>
						>
							<?php echo e(t('Select', [], 'global', $languageCode)); ?>

						</option>
						<?php if($field->options->count() > 0): ?>
							<?php $__currentLoopData = $field->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($option->tid); ?>"
										<?php if($defaultValue==$option->tid): ?>
											selected="selected"
										<?php endif; ?>
								>
									<?php echo e($option->value); ?>

								</option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</select>
					<small id="" class="form-text text-muted"><?php echo $field->help; ?></small>
				</div>
			</div>
		
		<?php elseif($field->type == 'textarea'): ?>
			
			<!-- textarea -->
			<div class="form-group row <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e($field->name); ?>

					<?php if($field->required == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<textarea class="form-control<?php echo e($errorClass); ?>"
							  id="<?php echo e($fieldId); ?>"
							  name="<?php echo e($fieldName); ?>"
							  placeholder="<?php echo e($field->name); ?>"
							  rows="10"><?php echo e($defaultValue); ?></textarea>
					<small id="" class="form-text text-muted"><?php echo $field->help; ?></small>
				</div>
			</div>
		
		<?php elseif($field->type == 'url'): ?>
			
			<!-- url -->
			<div class="form-group row <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e($field->name); ?>

					<?php if($field->required == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="text"
						   placeholder="<?php echo e($field->name); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?>"
						   value="<?php echo e($defaultValue); ?>">
					<small id="" class="form-text text-muted"><?php echo $field->help; ?></small>
				</div>
			</div>
		
		<?php elseif($field->type == 'number'): ?>
			
			<!-- number -->
			<div class="form-group row <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e($field->name); ?>

					<?php if($field->required == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="number"
						   placeholder="<?php echo e($field->name); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?>"
						   value="<?php echo e($defaultValue); ?>">
					<small id="" class="form-text text-muted"><?php echo $field->help; ?></small>
				</div>
			</div>
		
		<?php elseif($field->type == 'date'): ?>
			
			<!-- date -->
			<div class="form-group row <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e($field->name); ?>

					<?php if($field->required == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="text"
						   placeholder="<?php echo e($field->name); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?> cf-date"
						   value="<?php echo e($defaultValue); ?>"
						   autocomplete="off"
					>
					<small id="" class="form-text text-muted"><?php echo $field->help; ?></small>
				</div>
			</div>
			
		<?php elseif($field->type == 'date_time'): ?>
			
			<!-- date_time -->
			<div class="form-group row <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e($field->name); ?>

					<?php if($field->required == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="text"
						   placeholder="<?php echo e($field->name); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?> cf-date_time"
						   value="<?php echo e($defaultValue); ?>"
						   autocomplete="off"
					>
					<small id="" class="form-text text-muted"><?php echo $field->help; ?></small>
				</div>
			</div>
			
		<?php elseif($field->type == 'date_range'): ?>
			
			<!-- date_range -->
			<div class="form-group row <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e($field->name); ?>

					<?php if($field->required == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="text"
						   placeholder="<?php echo e($field->name); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?> cf-date_range"
						   value="<?php echo e($defaultValue); ?>"
						   autocomplete="off"
					>
					<small id="" class="form-text text-muted"><?php echo $field->help; ?></small>
				</div>
			</div>
			
		<?php else: ?>
			
			<!-- text -->
			<div class="form-group row <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e($field->name); ?>

					<?php if($field->required == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="text"
						   placeholder="<?php echo e($field->name); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?>"
						   value="<?php echo e($defaultValue); ?>">
					<small id="" class="form-text text-muted"><?php echo $field->help; ?></small>
				</div>
			</div>
			
		<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<script>
	$(function() {
		/*
		 * Custom Fields Date Picker
		 * https://www.daterangepicker.com/#options
		 */
		
		$('#cfContainer .cf-date').daterangepicker({
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
		$('#cfContainer .cf-date').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format')); ?>'));
		});
		
		
		$('#cfContainer .cf-date_time').daterangepicker({
			autoUpdateInput: false,
			autoApply: true,
			showDropdowns: false,
			minYear: parseInt(moment().format('YYYY')) - 100,
			maxYear: parseInt(moment().format('YYYY')) + 20,
			locale: {
				format: '<?php echo e(t('datepicker_format_datetime')); ?>',
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
			timePicker: true,
			timePicker24Hour: true,
			startDate: moment().format('<?php echo e(t('datepicker_format_datetime')); ?>')
		});
		$('#cfContainer .cf-date_time').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format_datetime')); ?>'));
		});
		
		
		$('#cfContainer .cf-date_range').daterangepicker({
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
		$('#cfContainer .cf-date_range').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format')); ?>') + ' - ' + picker.endDate.format('<?php echo e(t('datepicker_format')); ?>'));
		});
	});
</script>
<?php /**PATH /home/developer/public_html/resources/views/post/inc/fields.blade.php ENDPATH**/ ?>