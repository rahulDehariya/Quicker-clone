<?php $__env->startSection('search'); ?>
	##parent-placeholder-3559d7accf00360971961ca18989adc0614089c0##
    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'pages.inc.page-intro', 'pages.inc.page-intro'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">
                    
                    <?php if(empty($page->picture)): ?>
                        <h1 class="text-center title-1" style="color: <?php echo $page->name_color; ?>;"><strong><?php echo e($page->name); ?></strong></h1>
                        <hr class="center-block small mt-0" style="background-color: <?php echo $page->name_color; ?>;">
                    <?php endif; ?>
                    
					<div class="col-md-12 page-content">
						<div class="inner-box relative">
							<div class="row">
								<div class="col-sm-12 page-content">
                                    <?php if(empty($page->picture)): ?>
									    <h3 class="text-center" style="color: <?php echo $page->title_color; ?>;"><?php echo e($page->title); ?></h3>
                                    <?php endif; ?>
									<div class="text-content text-left from-wysiwyg">
										<?php echo $page->content; ?>

									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

				<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.social.horizontal', 'layouts.inc.social.horizontal'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('info'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/pages/cms.blade.php ENDPATH**/ ?>