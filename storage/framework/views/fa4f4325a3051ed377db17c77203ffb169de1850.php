<?php $__env->startSection('title', t('Page not found', [])); ?>

<?php $__env->startSection('search'); ?>
	##parent-placeholder-3559d7accf00360971961ca18989adc0614089c0##
	<?php echo $__env->make('errors/layouts/inc/search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php if(!(isset($paddingTopExists) and $paddingTopExists)): ?>
		<div class="h-spacer"></div>
	<?php endif; ?>
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">

					<div class="col-md-12 page-content">
						<div class="error-page" style="margin: 100px 0;">
							<h2 class="headline text-center" style="font-size: 180px; float: none;"> 404</h2>
							<div class="text-center m-l-0" style="margin-top: 60px;">
								<h3 class="m-t-0"><i class="fa fa-warning"></i> :-( <?php echo e(t('Page not found')); ?> !</h3>
								<p>
									<?php
									$defaultErrorMessage = t('Meanwhile, you may return to homepage', ['url' => lurl('/')]);
									?>
									<?php echo isset($exception) ? ($exception->getMessage() ? $exception->getMessage() : $defaultErrorMessage) : $defaultErrorMessage; ?>

								</p>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/errors/404.blade.php ENDPATH**/ ?>