<?php $__env->startSection('header'); ?>
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="mb-0">
                <?php echo e(trans('admin.add')); ?> <span class="text-lowercase"><?php echo $xPanel->entityName; ?></span>
            </h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
                <li class="breadcrumb-item"><a href="<?php echo e(admin_url()); ?>"><?php echo e(trans('admin.dashboard')); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(url($xPanel->route)); ?>" class="text-capitalize"><?php echo $xPanel->entityNamePlural; ?></a></li>
                <li class="breadcrumb-item active"><?php echo e(trans('admin.add')); ?></li>
            </ol>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="flex-row d-flex justify-content-center">
        <?php
        $colMd = config('settings.style.admin_boxed_layout') == '1' ? ' col-md-12' : ' col-md-9';
        ?>
        <div class="col-sm-12<?php echo e($colMd); ?>">
            
            <!-- Default box -->
            <?php if($xPanel->hasAccess('list')): ?>
                <a href="<?php echo e(url($xPanel->route)); ?>" class="btn btn-primary shadow">
                    <i class="fa fa-angle-double-left"></i> <?php echo e(trans('admin.back_to_all')); ?>

                    <span class="text-lowercase"><?php echo $xPanel->entityNamePlural; ?></span>
                </a>
                <br><br>
            <?php endif; ?>
            
            <?php echo Form::open(array('url' => $xPanel->route, 'method' => 'post', 'files' => $xPanel->hasUploadFields('create'))); ?>

            <div class="card border-top border-primary">
                
                <div class="card-header">
                    <h3 class="mb-0"><?php echo e(trans('admin.add_a_new')); ?> <?php echo $xPanel->entityName; ?></h3>
                </div>
                <div class="card-body">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <?php if(view()->exists('vendor.admin.panel.' . $xPanel->entityName . '.form_content')): ?>
                        <?php echo $__env->make('vendor.admin.panel.' . $xPanel->entityName . '.form_content', ['fields' => $xPanel->getFields('create')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php elseif(view()->exists('vendor.admin.panel.form_content')): ?>
                        <?php echo $__env->make('vendor.admin.panel.form_content', ['fields' => $xPanel->getFields('create')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php else: ?>
                        <?php echo $__env->make('admin::panel.form_content', ['fields' => $xPanel->getFields('create')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <?php echo $__env->make('admin::panel.inc.form_save_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/create.blade.php ENDPATH**/ ?>