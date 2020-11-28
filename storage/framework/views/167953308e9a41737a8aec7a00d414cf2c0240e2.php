
<?php
	$rawFullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
	$fullUrl = rawurldecode($rawFullUrl);
	$plugins = array_keys((array)config('plugins'));
	$publicDisk = \Storage::disk(config('filesystems.default'));
?>
<!DOCTYPE html>
<html lang="<?php echo e(ietfLangTag(config('app.locale'))); ?>"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.meta-robots', 'common.meta-robots'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-mobile-web-app-title" content="<?php echo e(config('settings.app.app_name')); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo e($publicDisk->url('app/default/ico/apple-touch-icon-144-precomposed.png') . getPictureVersion()); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo e($publicDisk->url('app/default/ico/apple-touch-icon-114-precomposed.png') . getPictureVersion()); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo e($publicDisk->url('app/default/ico/apple-touch-icon-72-precomposed.png') . getPictureVersion()); ?>">
	<link rel="apple-touch-icon-precomposed" href="<?php echo e($publicDisk->url('app/default/ico/apple-touch-icon-57-precomposed.png') . getPictureVersion()); ?>">
	<link rel="shortcut icon" href="<?php echo e(imgUrl(config('settings.app.favicon'), 'favicon')); ?>">
	<title><?php echo MetaTag::get('title'); ?></title>
	<?php echo MetaTag::tag('description'); ?><?php echo MetaTag::tag('keywords'); ?>

	<?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php if(strtolower($localeCode) == strtolower(config('lang.abbr', config('app.locales')))): ?>
			<link rel="canonical" href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode)); ?>"/>
		<?php else: ?>
			<link rel="alternate" href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode)); ?>" hreflang="<?php echo e(strtolower($localeCode)); ?>"/>
		<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php if(isset($post)): ?>
		<?php if(isVerifiedPost($post)): ?>
			<?php if(config('services.facebook.client_id')): ?>
				<meta property="fb:app_id" content="<?php echo e(config('services.facebook.client_id')); ?>" />
			<?php endif; ?>
			<?php echo $og->renderTags(); ?>

			<?php echo MetaTag::twitterCard(); ?>

		<?php endif; ?>
	<?php else: ?>
		<?php if(config('services.facebook.client_id')): ?>
			<meta property="fb:app_id" content="<?php echo e(config('services.facebook.client_id')); ?>" />
		<?php endif; ?>
		<?php echo $og->renderTags(); ?>

		<?php echo MetaTag::twitterCard(); ?>

	<?php endif; ?>
	<?php echo $__env->make('feed::links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php if(config('settings.seo.google_site_verification')): ?>
		<meta name="google-site-verification" content="<?php echo e(config('settings.seo.google_site_verification')); ?>" />
	<?php endif; ?>
	<?php if(config('settings.seo.msvalidate')): ?>
		<meta name="msvalidate.01" content="<?php echo e(config('settings.seo.msvalidate')); ?>" />
	<?php endif; ?>
	<?php if(config('settings.seo.alexa_verify_id')): ?>
		<meta name="alexaVerifyID" content="<?php echo e(config('settings.seo.alexa_verify_id')); ?>" />
	<?php endif; ?>
	<?php if(config('settings.seo.yandex_verification')): ?>
		<meta name="yandex-verification" content="<?php echo e(config('settings.seo.yandex_verification')); ?>" />
	<?php endif; ?>
	
	<?php if(file_exists(public_path('manifest.json'))): ?>
		<link rel="manifest" href="/manifest.json">
	<?php endif; ?>
	
	<?php echo $__env->yieldPushContent('before_styles_stack'); ?>
    <?php echo $__env->yieldContent('before_styles'); ?>
	
	<?php if(config('lang.direction') == 'rtl'): ?>
		<link href="https://fonts.googleapis.com/css?family=Cairo|Changa" rel="stylesheet">
		<link href="<?php echo e(url(mix('css/app.rtl.css'))); ?>" rel="stylesheet">
	<?php else: ?>
		<link href="<?php echo e(url(mix('css/app.css'))); ?>" rel="stylesheet">
	<?php endif; ?>
	<?php if(config('plugins.detectadsblocker.installed')): ?>
		<link href="<?php echo e(url('assets/detectadsblocker/css/style.css') . getPictureVersion()); ?>" rel="stylesheet">
	<?php endif; ?>
	
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.style', 'layouts.inc.tools.style'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
	<link href="<?php echo e(url('css/custom.css') . getPictureVersion()); ?>" rel="stylesheet">
	
	<?php echo $__env->yieldPushContent('after_styles_stack'); ?>
    <?php echo $__env->yieldContent('after_styles'); ?>
	
	<?php if(isset($plugins) and !empty($plugins)): ?>
		<?php $__currentLoopData = $plugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php echo $__env->yieldContent($plugin . '_styles'); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
    
    <?php if(config('settings.style.custom_css')): ?>
		<?php echo printCss(config('settings.style.custom_css')) . "\n"; ?>

    <?php endif; ?>
	
	<?php if(config('settings.other.js_code')): ?>
		<?php echo printJs(config('settings.other.js_code')) . "\n"; ?>

	<?php endif; ?>

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
 
	<script>
		paceOptions = {
			elements: true
		};
	</script>
	<script src="<?php echo e(url('assets/js/pace.min.js')); ?>"></script>
	<script src="<?php echo e(url('assets/plugins/modernizr/modernizr-custom.js')); ?>"></script>
	
	<?php $__env->startSection('recaptcha_scripts'); ?>
		<?php if(
			config('settings.security.recaptcha_activation')
			and config('recaptcha.site_key')
			and config('recaptcha.secret_key')
		): ?>
			<style>
				.is-invalid .g-recaptcha iframe,
				.has-error .g-recaptcha iframe {
					border: 1px solid #f85359;
				}
			</style>
			<?php if(config('recaptcha.version') == 'v3'): ?>
				<script type="text/javascript">
					function myCustomValidation(token){
						/* read HTTP status */
						/* console.log(token); */
						
						if ($('#gRecaptchaResponse').length) {
							$('#gRecaptchaResponse').val(token);
						}
					}
				</script>
				<?php echo recaptchaApiV3JsScriptTag([
					'action' 		    => request()->path(),
					'custom_validation' => 'myCustomValidation'
				]); ?>

			<?php else: ?>
				<?php echo recaptchaApiJsScriptTag(); ?>

			<?php endif; ?>
		<?php endif; ?>
	<?php echo $__env->yieldSection(); ?>
</head>
<body class="<?php echo e(config('app.skin')); ?>">
<div id="wrapper">
	
	<?php $__env->startSection('header'); ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.header', 'layouts.inc.header'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->yieldSection(); ?>

	<?php $__env->startSection('search'); ?>
	<?php echo $__env->yieldSection(); ?>
		
	<?php $__env->startSection('wizard'); ?>
	<?php echo $__env->yieldSection(); ?>
	
	<?php if(isset($siteCountryInfo)): ?>
		<div class="h-spacer"></div>
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="alert alert-warning">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?php echo $siteCountryInfo; ?>

					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php echo $__env->yieldContent('content'); ?>

	<?php $__env->startSection('info'); ?>
	<?php echo $__env->yieldSection(); ?>
	
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.auto', 'layouts.inc.advertising.auto'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
	<?php $__env->startSection('footer'); ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.footer', 'layouts.inc.footer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->yieldSection(); ?>

</div>

<?php $__env->startSection('modal_location'); ?>
<?php echo $__env->yieldSection(); ?>
<?php $__env->startSection('modal_abuse'); ?>
<?php echo $__env->yieldSection(); ?>
<?php $__env->startSection('modal_message'); ?>
<?php echo $__env->yieldSection(); ?>

<?php echo $__env->renderWhen(!auth()->check(), 'layouts.inc.modal.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.modal.change-country', 'layouts.inc.modal.change-country'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('cookieConsent::index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(config('plugins.detectadsblocker.installed')): ?>
	<?php if(view()->exists('detectadsblocker::modal')): ?>
		<?php echo $__env->make('detectadsblocker::modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php endif; ?>

<script>
	
	var siteUrl = '<?php echo url((!currentLocaleShouldBeHiddenInUrl() ? config('app.locale') : '') . '/'); ?>';
	var languageCode = '<?php echo config('app.locale'); ?>';
	var countryCode = '<?php echo config('country.code', 0); ?>';
	var timerNewMessagesChecking = <?php echo (int)config('settings.other.timer_new_messages_checking', 0); ?>;
	
	
	var langLayout = {
		'hideMaxListItems': {
			'moreText': "<?php echo e(t('View More')); ?>",
			'lessText': "<?php echo e(t('View Less')); ?>"
		},
		'select2': {
			errorLoading: function(){
				return "<?php echo t('The results could not be loaded'); ?>"
			},
			inputTooLong: function(e){
				var t = e.input.length - e.maximum, n = <?php echo t('Please delete X character'); ?>;
				return t != 1 && (n += 's'),n
			},
			inputTooShort: function(e){
				var t = e.minimum - e.input.length, n = <?php echo t('Please enter X or more characters'); ?>;
				return n
			},
			loadingMore: function(){
				return "<?php echo t('Loading more results'); ?>"
			},
			maximumSelected: function(e){
				var t = <?php echo t('You can only select N item'); ?>;
				return e.maximum != 1 && (t += 's'),t
			},
			noResults: function(){
				return "<?php echo t('No results found'); ?>"
			},
			searching: function(){
				return "<?php echo t('Searching'); ?>"
			}
		}
	};
</script>

<?php echo $__env->yieldPushContent('before_scripts_stack'); ?>
<?php echo $__env->yieldContent('before_scripts'); ?>

<script src="<?php echo e(url(mix('js/app.js'))); ?>"></script>
<?php if(config('settings.optimization.lazy_loading_activation') == 1): ?>
	<script src="<?php echo e(url('assets/plugins/lazysizes/lazysizes.min.js')); ?>" async=""></script>
<?php endif; ?>
<?php if(file_exists(public_path() . '/assets/plugins/select2/js/i18n/'.config('app.locale').'.js')): ?>
	<script src="<?php echo e(url('assets/plugins/select2/js/i18n/'.config('app.locale').'.js')); ?>"></script>
<?php endif; ?>
<?php if(config('plugins.detectadsblocker.installed')): ?>
	<script src="<?php echo e(url('assets/detectadsblocker/js/script.js') . getPictureVersion()); ?>"></script>
<?php endif; ?>
<script>
	$(document).ready(function () {
		
		$('.selecter').select2({
			language: langLayout.select2,
			dropdownAutoWidth: 'true',
			minimumResultsForSearch: Infinity,
			width: '100%'
		});
		
		
		$('.sselecter').select2({
			language: langLayout.select2,
			dropdownAutoWidth: 'true',
			width: '100%'
		});
		
		
		$('.share').ShareLink({
			title: '<?php echo e(addslashes(MetaTag::get('title'))); ?>',
			text: '<?php echo addslashes(MetaTag::get('title')); ?>',
			url: '<?php echo $rawFullUrl; ?>',
			width: 640,
			height: 480
		});
		
		
		<?php if(isset($errors) and $errors->any()): ?>
			<?php if($errors->any() and old('quickLoginForm')=='1'): ?>
				$('#quickLogin').modal();
			<?php endif; ?>
		<?php endif; ?>
	});
</script>

<?php echo $__env->yieldPushContent('after_scripts_stack'); ?>
<?php echo $__env->yieldContent('after_scripts'); ?>

<?php if(isset($plugins) and !empty($plugins)): ?>
	<?php $__currentLoopData = $plugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php echo $__env->yieldContent($plugin . '_scripts'); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(config('settings.footer.tracking_code')): ?>
	<?php echo printJs(config('settings.footer.tracking_code')) . "\n"; ?>

<?php endif; ?>

<!-- Start of HubSpot Embed Code -->
  <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/8722481.js"></script>
<!-- End of HubSpot Embed Code -->

</body>
</html><?php /**PATH /home/developer/public_html/resources/views/layouts/master.blade.php ENDPATH**/ ?>