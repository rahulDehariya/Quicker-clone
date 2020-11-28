<!DOCTYPE html>
<html dir="ltr" lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="<?php echo e(config('app.name')); ?>">
    
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(imgUrl(config('settings.app.favicon'), 'favicon')); ?>">
    
    <title><?php echo isset($title) ? strip_tags($title) . ' :: ' . config('app.name') . ' Admin' : config('app.name') . ' Admin'; ?></title>
    
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    
    <?php echo $__env->yieldContent('before_styles'); ?>
    
    <link rel="stylesheet" href="<?php echo e(asset('vendor/admin/plugins/pace/pace.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/admin/pnotify/pnotify.custom.min.css')); ?>">
    
    <link rel="canonical" href="<?php echo e(url()->current()); ?>" />
    
    
    <link href="<?php echo e(asset('vendor/admin-theme/css/style.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/admin-theme/css/style-main.css')); ?>" rel="stylesheet">

    <?php echo $__env->yieldContent('after_styles'); ?>
    
    <style>
        /* Fix for "datatables/css/jquery.dataTables.css" */
        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc,
        table.dataTable thead .sorting_asc_disabled,
        table.dataTable thead .sorting_desc_disabled {
            background-image: inherit;
        }
    </style>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="main-wrapper">
    
    
    <?php echo $__env->make('admin::layouts.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    
    <?php echo $__env->make('admin::layouts.inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    
    <div class="page-wrapper">
        
        <div class="container-fluid">
            
            <?php echo $__env->yieldContent('header'); ?>
            
            
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        
        
        <footer class="footer">
            <div class="row">
                <div class="col-md-6 text-left">
                    <?php echo e(trans('admin.Version')); ?> <?php echo e(config('app.version')); ?>

                </div>
                <?php if(config('settings.footer.hide_powered_by') != '1'): ?>
                    <div class="col-md-6 text-right">
                        <?php if(config('settings.footer.powered_by_info')): ?>
                            <?php echo e(trans('admin.powered_by')); ?> <?php echo config('settings.footer.powered_by_info'); ?>

                        <?php else: ?>
                            <?php echo e(trans('admin.powered_by')); ?> <a target="_blank" href="http://bedigit.com">Bedigit</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </footer>
    </div>
</div>

<?php echo $__env->yieldContent('before_scripts'); ?>

<script>
    var siteUrl = '<?php echo url('/'); ?>';
</script>


<script src="<?php echo e(asset('vendor/admin-theme/plugins/jquery/jquery.min.js')); ?>"></script>

<script src="<?php echo e(asset('vendor/admin-theme/plugins/popper.js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/admin-theme/plugins/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>

<script src="<?php echo e(asset('vendor/admin-theme/js/app.min.js')); ?>"></script>

<script src="<?php echo e(asset('vendor/admin-theme/plugins/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/admin-theme/plugins/sparkline/sparkline.js')); ?>"></script>

<script src="<?php echo e(asset('vendor/admin-theme/js/waves.js')); ?>"></script>

<script src="<?php echo e(asset('vendor/admin-theme/js/sidebarmenu.js')); ?>"></script>

<script src="<?php echo e(asset('vendor/admin-theme/js/feather.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/admin-theme/js/custom.js')); ?>"></script>

<script src="<?php echo e(asset('vendor/admin/plugins/pace/pace.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/admin/script.js')); ?>"></script>

<script>
    $(function () {
        "use strict";
        $("#main-wrapper").AdminSettings({
            Theme: <?php echo e(config('settings.style.admin_dark_theme') == '1' ? 'true' : 'false'); ?>,
            Layout: 'vertical',
            LogoBg: '<?php echo e(config('settings.style.admin_logo_bg')); ?>',
            NavbarBg: '<?php echo e(config('settings.style.admin_navbar_bg')); ?>',
            SidebarType: '<?php echo e(config('settings.style.admin_sidebar_type')); ?>',
            SidebarColor: '<?php echo e(config('settings.style.admin_sidebar_bg')); ?>',
            SidebarPosition: <?php echo e(config('settings.style.admin_sidebar_position') == '1' ? 'true' : 'false'); ?>,
            HeaderPosition: <?php echo e(config('settings.style.admin_header_position') == '1' ? 'true' : 'false'); ?>,
            BoxedLayout: <?php echo e(config('settings.style.admin_boxed_layout') == '1' ? 'true' : 'false'); ?>,
        });
    });
</script>


<script type="text/javascript">
    /* To make Pace works on Ajax calls */
    $(document).ajaxStart(function() { Pace.restart(); });
    
    /* Ajax calls should always have the CSRF token attached to them, otherwise they won't work */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    /* Set active state on menu element */
    var currentUrl = "<?php echo e(url(Route::current()->uri())); ?>";
    $("#sidebarnav li a").each(function() {
        if ($(this).attr('href').startsWith(currentUrl) || currentUrl.startsWith($(this).attr('href')))
        {
            $(this).parents('li').addClass('selected');
        }
    });
</script>
<script>
    $(document).ready(function()
    {
        /* Send an ajax update request */
        $(document).on('click', '.ajax-request', function(e)
        {
            e.preventDefault(); /* prevents the submit or reload */
            var confirmation = confirm("<?php echo trans('admin.confirm_this_action'); ?>");
            
            if (confirmation) {
                saveAjaxRequest(siteUrl, this);
            }
        });
    });
    
    function saveAjaxRequest(siteUrl, el)
    {
        if (isDemo()) {
            return false;
        }
        
        var $self = $(this); /* magic here! */
        
        /* Get database info */
        var _token = $('input[name=_token]').val();
        var dataTable = $(el).data('table');
        var dataField = $(el).data('field');
        var dataId = $(el).data('id');
        var dataLineId = $(el).data('line-id');
        var dataValue = $(el).data('value');
        
        /* Remove dot (.) from var (referring to the PHP var) */
        dataLineId = dataLineId.split('.').join("");
        
        
        $.ajax({
            method: 'POST',
            url: siteUrl + '/<?php echo admin_uri(); ?>/ajax/' + dataTable + '/' + dataField + '',
            context: this,
            data: {
                'primaryKey': dataId,
                '_token': _token
            }
        }).done(function(data) {
            /* Check 'status' */
            if (data.status != 1) {
                return false;
            }
            
            /* Decoration */
            if (data.table == 'countries' && dataField == 'active')
            {
                if (!data.resImport) {
                    new PNotify({
                        text: "<?php echo e(trans('admin.Error - You can not install this country')); ?>",
                        type: "error"
                    });
                    
                    return false;
                }
                
                if (data.isDefaultCountry == 1) {
                    new PNotify({
                        text: "<?php echo e(trans('admin.You can not disable the default country')); ?>",
                        type: "warning"
                    });
                    
                    return false;
                }
                
                /* Country case */
                if (data.fieldValue == 1) {
                    $('#' + dataLineId).removeClass('fa fa-toggle-off').addClass('fa fa-toggle-on');
                    $('#install' + dataId).removeClass('btn-light')
                            .addClass('btn-success')
                            .addClass('text-white')
                            .empty()
                            .html('<i class="fas fa-download"></i> <?php echo trans('admin.Installed'); ?>');
                } else {
                    $('#' + dataLineId).removeClass('fa fa-toggle-on').addClass('fa fa-toggle-off');
                    $('#install' + dataId).removeClass('btn-success')
                            .removeClass('text-white')
                            .addClass('btn-light')
                            .empty()
                            .html('<i class="fas fa-download"></i> <?php echo trans('admin.Install'); ?>');
                }
            }
            else
            {
                /* All others cases */
                if (data.fieldValue == 1) {
                    $('#' + dataLineId).removeClass('fa fa-toggle-off').addClass('fa fa-toggle-on').blur();
                } else {
                    $('#' + dataLineId).removeClass('fa fa-toggle-on').addClass('fa fa-toggle-off').blur();
                }
            }
            
            return false;
        }).fail(function(xhr, textStatus, errorThrown) {
            /*
			console.log('FAILURE: ' + textStatus);
			console.log(xhr);
			*/
            
            /* Show an alert with the result */
            /* console.log(xhr.responseText); */
            if (typeof xhr.responseText !== 'undefined') {
                if (xhr.responseText.indexOf("<?php echo e(trans('admin.unauthorized')); ?>") >= 0) {
                    new PNotify({
                        text: xhr.responseText,
                        type: "error"
                    });
                    
                    return false;
                }
            }
            
            /* Show an alert with the standard message */
            new PNotify({
                text: xhr.responseText,
                type: "error"
            });
            
            return false;
        });
        
        return false;
    }
    
    function isDemo()
    {
        <?php
            $varJs = isDemo() ? 'var demoMode = true;' : 'var demoMode = false;';
            echo $varJs . "\n";
        ?>
        var msg = '<?php echo e(addcslashes(t('demo_mode_message'), "'")); ?>';
        
        if (demoMode) {
            new PNotify({title: 'Information', text: msg, type: "info"});
            return true;
        }
        
        return false;
    }
</script>

<?php echo $__env->make('admin::layouts.inc.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin::layouts.inc.maintenance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
    $(document).ready(function () {
        <?php if(isset($errors) and $errors->any()): ?>
        <?php if($errors->any() and old('maintenanceForm')=='1'): ?>
        $('#maintenanceMode').modal();
        <?php endif; ?>
        <?php endif; ?>
    });
</script>

<?php echo $__env->yieldContent('after_scripts'); ?>
</body>
</html><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/layouts/master.blade.php ENDPATH**/ ?>