<?php if(isset($errors) and $errors->any()): ?>
    <div class="col-xl-12">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><strong><?php echo e(t('oops_an_error_has_occurred')); ?></strong></h5>
            <ul class="list list-check">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<?php if(Session::has('flash_notification')): ?>
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
<?php endif; ?><?php /**PATH /home/developer/public_html/resources/views/post/inc/notification.blade.php ENDPATH**/ ?>