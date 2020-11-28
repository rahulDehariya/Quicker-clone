<?php if(!empty($page->picture)): ?>
<div class="intro-inner">
	<div class="about-intro" style="background:url(<?php echo e(imgUrl($page->picture, 'bgHeader')); ?>) no-repeat center;background-size:cover;">
		<div class="dtable hw100">
			<div class="dtable-cell hw100">
				<div class="container text-center">
					<h1 class="intro-title animated fadeInDown" style="color: <?php echo $page->name_color; ?>;"> <?php echo e($page->name); ?> </h1>
                    <h3 class="text-center title-1" style="color: <?php echo $page->title_color; ?>;"><strong><?php echo e($page->title); ?></strong></h3>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/pages/inc/page-intro.blade.php ENDPATH**/ ?>