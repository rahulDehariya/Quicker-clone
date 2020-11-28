<?php if(isset($customFields) and $customFields->count() > 0): ?>
	<div class="row" id="cfContainer">
		<div class="col-xl-12">
			<div class="row pl-2 pr-2">
				<div class="col-xl-12 pb-2 pl-1 pr-1">
					<h4><i class="icon-th-list"></i> <?php echo e(t('Additional Details')); ?></h4>
				</div>
			</div>
		</div>
		
		<div class="col-xl-12">
			<div class="row pl-2 pr-2">
				<?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					if (in_array($field->type, ['radio', 'select'])) {
						if (is_numeric($field->default)) {
							$option = \App\Models\FieldOption::findTrans($field->default);
							if (!empty($option)) {
								$field->default = $option->value;
							}
						}
					}
					if (in_array($field->type, ['checkbox'])) {
						$field->default = ($field->default == 1) ? t('Yes') : t('No');
					}
					if ($field->type == 'video') {
						$field->default = \App\Helpers\VideoEmbedding::embedVideo($field->default);
					}
					?>
					<?php if($field->type == 'file'): ?>
						<div class="detail-line col-xl-12 pb-2 pl-1 pr-1">
							<div class="rounded-small ml-0 mr-0 p-2">
								<span class="detail-line-label" style="padding-top: 8px;"><?php echo e($field->name); ?></span>
								<span class="detail-line-value">
									<a class="btn btn-default" href="<?php echo e(fileUrl($field->default)); ?>" target="_blank">
										<i class="icon-attach-2"></i> <?php echo e(t('Download')); ?>

									</a>
								</span>
							</div>
						</div>
					<?php else: ?>
						<?php if(!is_array($field->default) and $field->type != 'video'): ?>
							<?php if($field->type == 'url'): ?>
								<div class="detail-line col-sm-6 col-xs-12 pb-2 pl-1 pr-1">
									<div class="rounded-small p-2">
										<span class="detail-line-label"><?php echo e($field->name); ?></span>
										<span class="detail-line-value">
											<a href="<?php echo e(addHttp($field->default)); ?>" target="_blank" rel="nofollow"><?php echo e(addHttp($field->default)); ?></a>
										</span>
									</div>
								</div>
							<?php else: ?>
								<div class="detail-line col-sm-6 col-xs-12 pb-2 pl-1 pr-1">
									<div class="rounded-small p-2">
										<span class="detail-line-label"><?php echo e($field->name); ?></span>
										<span class="detail-line-value"><?php echo e($field->default); ?></span>
									</div>
								</div>
							<?php endif; ?>
						<?php elseif(!is_array($field->default) and $field->type == 'video'): ?>
							<div class="detail-line col-xl-12 pb-2 pl-1 pr-1">
								<div class="rounded-small p-2">
									<span><?php echo e($field->name); ?>:</span>
									<div class="row m-0 p-2">
										<div class="col-lg-12 col-md-12 col-sm-12 text-center embed-responsive embed-responsive-16by9">
											<?php echo $field->default; ?>

										</div>
									</div>
								</div>
							</div>
						<?php else: ?>
							<?php if(count($field->default) > 0): ?>
							<div class="detail-line col-xl-12 pb-2 pl-1 pr-1">
								<div class="rounded-small p-2">
									<span><?php echo e($field->name); ?>:</span>
									<div class="row m-0 p-2">
										<?php $__currentLoopData = $field->default; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valueItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php if(!isset($valueItem->value)) continue; ?>
											<div class="col-sm-4 col-xs-6 col-xxs-12">
												<div class="m-0">
													<i class="fa fa-check"></i> <?php echo e($valueItem->value); ?>

												</div>
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
							</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php /**PATH /home/developer/public_html/resources/views/post/inc/fields-values.blade.php ENDPATH**/ ?>