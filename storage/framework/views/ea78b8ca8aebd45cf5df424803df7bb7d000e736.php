<?php $__env->startSection('content'); ?>
<div class="container welcome">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome!</div>
                <div class="panel-body">
                    This's Groupwarelike Application for the Schedule Management and Communication
                    with Group Members.
                </div>
            </div>

            <!-- Authentication Links -->
            <?php if(Auth::guest()): ?>
            <div class="login-btn">
                <a href="<?php echo e(url('/login')); ?>"><button type="button" class="btn btn-primary">
                  Login
                </button></a>
                <a href="<?php echo e(url('/register')); ?>"><button type="button" class="btn btn-primary">
                  Register
                </button></a>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>