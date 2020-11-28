<div class="reg-sidebar-inner text-center">
	
	<?php if(getSegment(1) == 'create' or getSegment(2) == 'create'): ?>
		
		<div class="promo-text-box">
			<i class="icon-picture fa fa-4x icon-color-1"></i>
			<h3><strong><?php echo e(t('post_free_ads')); ?></strong></h3>
			<p>
				<?php echo e(t('do_you_have_something_text', ['appName' => config('app.name')])); ?>

			</p>
		</div>
	<?php else: ?>
		
		<?php if(config('settings.single.publication_form_type') == '2'): ?>
			
			<?php if(auth()->check()): ?>
				<?php if(auth()->user()->id == $post->user_id): ?>
					<div class="card sidebar-card panel-contact-seller">
						<div class="card-header"><?php echo e(t('author_actions')); ?></div>
						<div class="card-content user-info">
							<div class="card-body text-center">
								<a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>" class="btn btn-default btn-block">
									<i class="icon-right-hand"></i> <?php echo e(t('Return to the Ad')); ?>

								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			
		<?php else: ?>
			
			<?php if(auth()->check()): ?>
				<?php if(auth()->user()->id == $post->user_id): ?>
					<div class="card sidebar-card panel-contact-seller">
						<div class="card-header"><?php echo e(t('author_actions')); ?></div>
						<div class="card-content user-info">
							<div class="card-body text-center">
								<a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>" class="btn btn-default btn-block">
									<i class="icon-right-hand"></i> <?php echo e(t('Return to the Ad')); ?>

								</a>
								<a href="<?php echo e(lurl('posts/' . $post->id . '/photos')); ?>" class="btn btn-default btn-block">
									<i class="icon-camera-1"></i> <?php echo e(t('Update Photos')); ?>

								</a>
								<?php if(isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0): ?>
									<a href="<?php echo e(lurl('posts/' . $post->id . '/payment')); ?>" class="btn btn-success btn-block">
										<i class="icon-ok-circled2"></i> <?php echo e(t('Make It Premium')); ?>

									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			
		<?php endif; ?>
	<?php endif; ?>
	
	<div class="card sidebar-card border-color-primary">
		<div class="card-header bg-primary border-color-primary text-white uppercase">
			<small><strong><?php echo e(t('how_to_sell_quickly')); ?></strong></small>
		</div>
		<div class="card-content">
			<div class="card-body text-left">
				<ul class="list-check">
					<li> <?php echo e(t('sell_quickly_advice_1')); ?> </li>
					<li> <?php echo e(t('sell_quickly_advice_2')); ?></li>
					<li> <?php echo e(t('sell_quickly_advice_3')); ?></li>
					<li> <?php echo e(t('sell_quickly_advice_4')); ?></li>
					<li> <?php echo e(t('sell_quickly_advice_5')); ?></li>
				</ul>
			</div>
		</div>
	</div>
	
</div><?php /**PATH /home/developer/public_html/resources/views/post/createOrEdit/inc/right-sidebar.blade.php ENDPATH**/ ?>