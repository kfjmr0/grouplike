

<?php $__env->startSection('action', url('/task')); ?>

<?php $__env->startSection('date_setting'); ?>
<?php
    $selected_month = $date->format('n');
    $selected_day = $date->format('j');
    $last_day = $date->format('t');
    $selected_start_hour = 9;
    $selected_start_minute = 0;
    $selected_end_hour = 17;
    $selected_end_minute = 0;
?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('submit_button'); ?>
  <button type="submit" class="btn btn-primary">Add</button>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('task.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>