

<?php $__env->startSection('contentLoginmenu'); ?>
    <div class="mymenu">
      <li><a href="#">Message</a></li>
      <li><a href="<?php echo e(url('/schedule')); ?>">Schedule</a></li>
      <li><a href="#">Chat</a></li>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>