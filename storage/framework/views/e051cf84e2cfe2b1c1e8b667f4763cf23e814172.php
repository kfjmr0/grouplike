

<?php $__env->startSection('action', url('/task/edit/' .$task->id)); ?>
<?php $__env->startSection('http_method', method_field('PATCH')); ?>

<?php $__env->startSection('date_setting'); ?>
<?php
    $selected_month = $date->format('n');
    $selected_day = $date->format('j');
    $last_day = $date->format('t');
    $selected_start_hour = (int)$start_time[0];
    $selected_start_minute = (int)$start_time[1];
    $selected_end_hour = 17;
    $selected_end_minute = 0;
?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('task_name', $task->name); ?>

<?php $__env->startSection('submit_button'); ?>
  <button type="submit" class="btn btn-success">Save</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('delete_button'); ?>
  <form class="delete-task" action="<?php echo e(url('/task/' .$task->id)); ?>" method="post">
    <?php echo e(csrf_field()); ?>

    <?php echo e(method_field('DELETE')); ?>

    <button type="submit" class="btn btn-danger">Delete</button>
  </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('task.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>