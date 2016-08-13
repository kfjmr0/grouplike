<?php
$weekArray = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
$period = new \DatePeriod(
    $origin,
    $interval,
    $endpoint
);
?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('menubar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">New Message</div>
                <table class="table message-table">
                  <tbody>
                      <?php $__empty_1 = true; foreach($new_messages as $message): $__empty_1 = false; ?>
                        <tr data-href="<?php echo e(url('/message/show/' .$message->id)); ?>">
                          <td><?php echo e($message->sender_name); ?></td>
                          <td><?php echo e($message->title); ?></td>
                        </tr>
                      <?php endforeach; if ($__empty_1): ?>
                        <div class="panel-body"></div>
                      <?php endif; ?>
                  </tbody>
                </table>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">My Schedule</div>
                <div class="calendar">
                  <div class="weekly">
                    <table>
                        <tr>
                            <?php foreach($period as $day): ?>
                              <th class="<?php echo e($weekArray[$day->format('w')]); ?>">
                                <?php echo e($day->format('n/j(D)')); ?>

                              </th>
                            <?php endforeach; ?>
                        </tr>
                        <?php foreach($user_tasks as $user_task): ?>
                          <tr>
                              <?php $i = 0; ?>
                              <?php foreach($period as $day): ?>
                                <td class="<?php echo e($weekArray[$day->format('w')]); ?>">
                                    <!-- make add-task function invalid for now 
                                    <a href="<?php echo e(url('/task/add/' .$day->format('Y-m-d'))); ?>"><i class="glyphicon glyphicon-plus"></i></a><br/>
                                    -->
                                    <?php if(!empty($user_task['task'][$i])): ?>
                                        <?php foreach($user_task['task'][$i] as $task): ?>
                                          <?php echo e($task['start_time'] .'~'. $task['end_time']); ?><br/>
                                          <?php echo e($task['name']); ?><br/>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </td>
                                <?php $i++; ?>
                              <?php endforeach; ?>
                          </tr>
                        <?php endforeach; ?>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
  <?php echo $__env->make('table_clickable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>