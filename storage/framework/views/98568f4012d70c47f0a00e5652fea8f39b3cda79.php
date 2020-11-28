<?php $__env->startSection('content'); ?>
	
	<?php if(isset($errors) and $errors->any()): ?>
        <div class="alert alert-danger ml-0 mr-0 mb-5">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($error); ?><br>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
	<?php endif; ?>
    
    <?php if(session('status')): ?>
        <div class="alert alert-success ml-0 mr-0 mb-5">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>
    
    <div id="loginform">
        
        <div class="logo">
            <h3 class="box-title mb-3"><?php echo e(trans('admin.login')); ?></h3>
        </div>
        
        
        <div class="row">
            <div class="col-12">
                
                <form class="form-horizontal mt-3" id="loginform" action="<?php echo e(admin_url('login')); ?>" method="post">
                    <?php echo csrf_field(); ?>

                    
                    
                    <div class="form-group mb-3<?php echo e($errors->has('email') ? ' has-danger' : ''); ?>">
                        <div class="">
                            <input class="form-control<?php echo e($errors->has('email') ? ' form-control-danger' : ''); ?>"
                                   type="text"
                                   name="email"
                                   value="<?php echo e(old('email')); ?>"
                                   placeholder="<?php echo e(trans('admin.email_address')); ?>"
                            >
                        </div>
    
                        <?php if($errors->has('email')): ?>
                            <small class="form-control-feedback"><?php echo e($errors->first('email')); ?></small>
                        <?php endif; ?>
                    </div>
                    
                    
                    <div class="form-group mb-4<?php echo e($errors->has('password') ? ' has-danger' : ''); ?>">
                        <div class="">
                            <input class="form-control<?php echo e($errors->has('email') ? ' form-control-danger' : ''); ?>"
                                   type="password"
                                   name="password"
                                   placeholder="<?php echo e(trans('admin.password')); ?>"
                            >
                        </div>
    
                        <?php if($errors->has('password')): ?>
                            <small class="form-control-feedback"><?php echo e($errors->first('password')); ?></small>
                        <?php endif; ?>
                    </div>
                    
                    
                    <?php echo $__env->make('layouts.inc.tools.recaptcha', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    
                    
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="checkbox checkbox-info pt-0">
                                <input id="checkbox-signup" name="remember" type="checkbox" class="material-inputs chk-col-indigo">
                                <label for="checkbox-signup"> <?php echo e(trans('admin.remember_me')); ?> </label>
                            </div>
                            <div class="ml-auto">
                                <a href="javascript:void(0)" id="to-recover" class="text-muted float-right">
                                    <i class="fa fa-lock mr-1"></i> <?php echo e(trans('admin.forgot_your_password')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group text-center mt-4">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block waves-effect waves-light" type="submit"><?php echo e(trans('admin.login')); ?></button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
        
    </div>
    
    <?php echo $__env->make('admin::auth.passwords.inc.recover-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/developer/public_html/resources/views/vendor/admin/auth/login.blade.php ENDPATH**/ ?>