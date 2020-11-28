<div id="stepWizard" class="container">
    <div class="row">
        <div class="col-xl-12">
            <section>
                <div class="wizard">
                    
                    <ul class="nav nav-wizard">
                        <?php if(getSegment(2) == 'create'): ?>
                            <?php $uriPath = getSegment(4); ?>
							<?php if(!in_array($uriPath, ['finish'])): ?>
								<li class="<?php echo e(($uriPath == '') ? 'active' : (in_array($uriPath, ['photos', 'packages', 'finish']) or (isset($post) and !empty($post)) ? '' : 'disabled')); ?>">
									<?php if(isset($post) and !empty($post)): ?>
										<a href="<?php echo e(lurl('posts/create/' . $post->tmp_token)); ?>"><?php echo e(t('ad_details')); ?></a>
									<?php else: ?>
										<a href="<?php echo e(lurl('posts/create')); ?>"><?php echo e(t('ad_details')); ?></a>
									<?php endif; ?>
								</li>
							
								<li class="picturesBloc <?php echo e(($uriPath == 'photos') ? 'active' : ((in_array($uriPath, ['photos', 'packages', 'finish']) or (isset($post) and !empty($post))) ? '' : 'disabled')); ?>">
									<?php if(isset($post) and !empty($post)): ?>
										<a href="<?php echo e(lurl('posts/create/' . $post->tmp_token . '/photos')); ?>"><?php echo e(t('Photos')); ?></a>
									<?php else: ?>
										<a><?php echo e(t('Photos')); ?></a>
									<?php endif; ?>
								</li>
			
								<?php if(isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0): ?>
								<li class="<?php echo e(($uriPath == 'payment') ? 'active' : ((in_array($uriPath, ['finish']) or (isset($post) and !empty($post))) ? '' : 'disabled')); ?>">
									<?php if(isset($post) and !empty($post)): ?>
										<a href="<?php echo e(lurl('posts/create/' . $post->tmp_token . '/payment')); ?>"><?php echo e(t('Payment')); ?></a>
									<?php else: ?>
										<a><?php echo e(t('Payment')); ?></a>
									<?php endif; ?>
								</li>
								<?php endif; ?>
							<?php endif; ?>
                            
                            <?php if($uriPath == 'activation'): ?>
                            <li class="<?php echo e(($uriPath == 'activation') ? 'active' : 'disabled'); ?>">
                                <a><?php echo e(t('Activation')); ?></a>
                            </li>
                            <?php else: ?>
                            <li class="<?php echo e(($uriPath == 'finish') ? 'active' : 'disabled'); ?>">
                                <a><?php echo e(t('Finish')); ?></a>
                            </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php $uriPath = getSegment(3); ?>
							<?php if(!in_array($uriPath, ['finish'])): ?>
								<li class="<?php echo e((in_array($uriPath, [null, 'edit'])) ? 'active' : ''); ?>">
									<?php if(isset($post) and !empty($post)): ?>
										<a href="<?php echo e(lurl('posts/' . $post->id . '/edit')); ?>"><?php echo e(t('ad_details')); ?></a>
									<?php else: ?>
										<a href="<?php echo e(lurl('posts/create')); ?>"><?php echo e(t('ad_details')); ?></a>
									<?php endif; ?>
								</li>
							
								<li class="picturesBloc <?php echo e(($uriPath == 'photos') ? 'active' : ''); ?>">
									<?php if(isset($post) and !empty($post)): ?>
										<a href="<?php echo e(lurl('posts/' . $post->id . '/photos')); ?>"><?php echo e(t('Photos')); ?></a>
									<?php else: ?>
										<a><?php echo e(t('Photos')); ?></a>
									<?php endif; ?>
								</li>
			
								<?php if(isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0): ?>
								<li class="<?php echo e(($uriPath == 'payment') ? 'active' : ''); ?>">
									<?php if(isset($post) and !empty($post)): ?>
										<a href="<?php echo e(lurl('posts/' . $post->id . '/payment')); ?>"><?php echo e(t('Payment')); ?></a>
									<?php else: ?>
										<a><?php echo e(t('Payment')); ?></a>
									<?php endif; ?>
								</li>
								<?php endif; ?>
							<?php endif; ?>
        
                            <li class="<?php echo e(($uriPath == 'finish') ? 'active' : 'disabled'); ?>">
                                <a><?php echo e(t('Finish')); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    
                </div>
            </section>
        </div>
    </div>
</div>

<?php $__env->startSection('after_styles'); ?>
    ##parent-placeholder-bb86d4c64894d7d4416e528718347e64591a36f9##
	<?php if(config('lang.direction') == 'rtl'): ?>
    	<link href="<?php echo e(url('assets/css/rtl/wizard.css')); ?>" rel="stylesheet">
	<?php else: ?>
		<link href="<?php echo e(url('assets/css/wizard.css')); ?>" rel="stylesheet">
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('after_scripts'); ?>
    ##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
<?php $__env->stopSection(); ?><?php /**PATH /home/developer/public_html/resources/views/post/createOrEdit/multiSteps/inc/wizard.blade.php ENDPATH**/ ?>