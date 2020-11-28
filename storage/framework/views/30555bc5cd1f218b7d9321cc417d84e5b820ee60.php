<?php if(config('settings.single.activation_facebook_comments') and config('services.facebook.client_id') and !$commentsAreDisabledByUser): ?>
	<div class="container">
		<div id="fb-root"></div>
		<script>
			(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/<?php echo e(config('lang.locale', 'en_US')); ?>/sdk.js#xfbml=1&version=v2.5&appId=<?php echo e(config('services.facebook.client_id')); ?>";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<div class="fb-comments" data-href="<?php echo e(request()->url()); ?>" data-width="100%" data-numposts="5"></div>
	</div>
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/layouts/inc/tools/facebook-comments.blade.php ENDPATH**/ ?>