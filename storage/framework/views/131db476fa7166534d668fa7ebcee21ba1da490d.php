<!DOCTYPE html>
<html dir="ltr" lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="<?php echo e(config('app.name')); ?>">
    
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(imgUrl(config('settings.app.favicon'), 'favicon')); ?>">
    
    <title><?php echo e(isset($title) ? $title.' :: ' . config('app.name') . ' Admin' : config('app.name') . ' Admin'); ?></title>
    
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    
    <?php echo $__env->yieldContent('before_styles'); ?>
    
    <link rel="stylesheet" href="<?php echo e(asset('vendor/admin/plugins/pace/pace.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/admin/pnotify/pnotify.custom.min.css')); ?>">
    
    <link rel="canonical" href="<?php echo e(url()->current()); ?>" />
    
    
    <link href="<?php echo e(asset('vendor/admin-theme/css/style.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/admin-theme/css/style-main.css')); ?>" rel="stylesheet">

    <?php echo $__env->yieldContent('after_styles'); ?>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <?php echo $__env->yieldContent('recaptcha_scripts'); ?>
</head>

<body>
<div class="main-wrapper">
    
    
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
         style="background:url(<?php echo e(imgUrl(config('settings.app.login_bg_image'), 'bgBody')); ?>) no-repeat center center; background-size: cover;"
    >
        <div class="auth-box p-4 bg-white rounded">
    
            <div class="logo text-center mb-5">
                <a href="<?php echo e(url('/')); ?>">
                    <img src="<?php echo e(imgUrl(config('settings.app.logo_dark'), 'adminLogo')); ?>" alt="logo" class="img-fluid" style="width:250px; height:auto;">
                </a>
                <hr>
            </div>
            
            <?php echo $__env->yieldContent('content'); ?>
            
        </div>
    </div>
    
</div>

<?php echo $__env->yieldContent('before_scripts'); ?>

<script>
    var siteUrl = '<?php echo url('/'); ?>';
</script>


<script src="<?php echo e(asset('vendor/admin-theme/plugins/jquery/jquery.min.js')); ?>"></script>

<script src="<?php echo e(asset('vendor/admin-theme/plugins/popper.js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/admin-theme/plugins/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>


<script>
    $(document).ready(function()
    {
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        
        
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
        $('#to-login').on("click", function() {
            $("#recoverform").slideUp();
            $("#loginform").fadeIn();
        });
    });
</script>

<?php echo $__env->make('admin::layouts.inc.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('after_scripts'); ?>

</body>
</html><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/layouts/auth.blade.php ENDPATH**/ ?>