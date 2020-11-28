<aside>
	<div class="inner-box">
		<div class="user-panel-sidebar">

			<div class="collapse-box">
				<h5 class="collapse-title no-border">
					<?php echo e(t('My Account')); ?>&nbsp;
					<a href="#MyClassified" data-toggle="collapse" class="pull-right"><i class="fa fa-angle-down"></i></a>
				</h5>
				<div class="panel-collapse collapse show" id="MyClassified">
					<ul class="acc-list">
						<li>
							<a <?php echo ($pagePath=='') ? 'class="active"' : ''; ?> href="<?php echo e(lurl('account')); ?>">
								<i class="icon-home"></i> <?php echo e(t('Personal Home')); ?>

							</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- /.collapse-box  -->

			<div class="collapse-box">
				<h5 class="collapse-title">
					<?php echo e(t('my_ads')); ?>

					<a href="#MyAds" data-toggle="collapse" class="pull-right"><i class="fa fa-angle-down"></i></a>
				</h5>
				<div class="panel-collapse collapse show" id="MyAds">
					<ul class="acc-list">
						<li>
							<a<?php echo ($pagePath=='my-posts') ? ' class="active"' : ''; ?> href="<?php echo e(lurl('account/my-posts')); ?>">
							<i class="icon-docs"></i> <?php echo e(t('my_ads')); ?>&nbsp;
							<span class="badge badge-pill">
								<?php echo e(isset($countMyPosts) ? \App\Helpers\Number::short($countMyPosts) : 0); ?>

							</span>
							</a>
						</li>
						<li>
							<a<?php echo ($pagePath=='favourite') ? ' class="active"' : ''; ?> href="<?php echo e(lurl('account/favourite')); ?>">
							<i class="icon-heart"></i> <?php echo e(t('favourite_ads')); ?>&nbsp;
							<span class="badge badge-pill">
								<?php echo e(isset($countFavouritePosts) ? \App\Helpers\Number::short($countFavouritePosts) : 0); ?>

							</span>
							</a>
						</li>
						<li>
							<a<?php echo ($pagePath=='saved-search') ? ' class="active"' : ''; ?> href="<?php echo e(lurl('account/saved-search')); ?>">
							<i class="icon-star-circled"></i> <?php echo e(t('Saved searches')); ?>&nbsp;
							<span class="badge badge-pill">
								<?php echo e(isset($countSavedSearch) ? \App\Helpers\Number::short($countSavedSearch) : 0); ?>

							</span>
							</a>
						</li>
						<li>
							<a<?php echo ($pagePath=='pending-approval') ? ' class="active"' : ''; ?> href="<?php echo e(lurl('account/pending-approval')); ?>">
							<i class="icon-hourglass"></i> <?php echo e(t('pending_approval')); ?>&nbsp;
							<span class="badge badge-pill">
								<?php echo e(isset($countPendingPosts) ? \App\Helpers\Number::short($countPendingPosts) : 0); ?>

							</span>
							</a>
						</li>
						<li>
							<a<?php echo ($pagePath=='archived') ? ' class="active"' : ''; ?> href="<?php echo e(lurl('account/archived')); ?>">
							<i class="icon-folder-close"></i> <?php echo e(t('archived_ads')); ?>&nbsp;
							<span class="badge badge-pill">
								<?php echo e(isset($countArchivedPosts) ? \App\Helpers\Number::short($countArchivedPosts) : 0); ?>

							</span>
							</a>
						</li>
						<li>
							<a<?php echo ($pagePath=='conversations') ? ' class="active"' : ''; ?> href="<?php echo e(lurl('account/conversations')); ?>">
							<i class="icon-mail-1"></i> <?php echo e(t('Conversations')); ?>&nbsp;
							<span class="badge badge-pill">
								<?php echo e(isset($countConversations) ? \App\Helpers\Number::short($countConversations) : 0); ?>

							</span>&nbsp;
							<span class="badge badge-pill badge-important count-conversations-with-new-messages">0</span>
							</a>
						</li>
						<li>
							<a<?php echo ($pagePath=='transactions') ? ' class="active"' : ''; ?> href="<?php echo e(lurl('account/transactions')); ?>">
							<i class="icon-money"></i> <?php echo e(t('Transactions')); ?>&nbsp;
							<span class="badge badge-pill">
								<?php echo e(isset($countTransactions) ? \App\Helpers\Number::short($countTransactions) : 0); ?>

							</span>
							</a>
						</li>
						<?php if(config('plugins.api.installed')): ?>
							<li>
								<a<?php echo ($pagePath=='api-dashboard') ? ' class="active"' : ''; ?> href="<?php echo e(lurl('account/api-dashboard')); ?>">
									<i class="icon-cog"></i> <?php echo e(trans('api::messages.Clients & Applications')); ?>&nbsp;
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<!-- /.collapse-box  -->

			<div class="collapse-box">
				<h5 class="collapse-title">
					<?php echo e(t('Terminate Account')); ?>&nbsp;
					<a href="#TerminateAccount" data-toggle="collapse" class="pull-right"><i class="fa fa-angle-down"></i></a>
				</h5>
				<div class="panel-collapse collapse show" id="TerminateAccount">
					<ul class="acc-list">
						<li>
							<a <?php echo ($pagePath=='close') ? 'class="active"' : ''; ?> href="<?php echo e(lurl('account/close')); ?>">
								<i class="icon-cancel-circled "></i> <?php echo e(t('Close account')); ?>

							</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- /.collapse-box  -->

		</div>
	</div>
	<!-- /.inner-box  -->
</aside><?php /**PATH /home/developer/public_html/resources/views/account/inc/sidebar.blade.php ENDPATH**/ ?>