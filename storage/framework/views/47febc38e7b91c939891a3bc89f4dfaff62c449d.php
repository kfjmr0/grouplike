<!-- resources/views/task/index.blade.php -->


<?php
$weekArray = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
$next_week = clone $origin;
$next_week->add(\DateInterval::createFromDateString('7day'));
$last_week = clone $origin;
$last_week->sub(\DateInterval::createFromDateString('7day'));
$period = new \DatePeriod(
    $origin,
    $interval,
    $endpoint
);
$j = 0;
?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('menubar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="calendar" id="schedule-page-weekly-calendar">
  <div class="calendar-nav">
    <div class="btn-group" role="group">
      <a href="<?php echo e(url('/task/add')); ?>" class="btn btn-primary" role="button">
        Add Task
      </a>
    	<a href="<?php echo e(url('/task/' .$last_week->format('Y-m-d'))); ?>" class="btn btn-default" role="button">
        <i class="glyphicon glyphicon-chevron-left"></i>Last Week
      </a>
    	<a href="<?php echo e(url('/task/' .$next_week->format('Y-m-d'))); ?>" class="btn btn-default" role="button">
        Next Week<i class="glyphicon glyphicon-chevron-right"></i>
      </a>
    </div>
  </div>


  <div class="weekly">
    <table>
        <tr>
            <th></th>
            <?php foreach($period as $day): ?>
              <th class="<?php echo e($weekArray[$day->format('w')]); ?>">
                <?php echo e($day->format('n/j(D)')); ?>

              </th>
            <?php endforeach; ?>
        </tr>
        <?php foreach($user_tasks as $user_task): ?>
          <tr>
              <th class="username">
                <?php echo e($user_task['user_name']); ?><br/>
                <!--
                <a href="#"><button type="button">Monthly</button></a>
                -->
              </th>
              <?php $i = 0; ?>
              <?php foreach($period as $day): ?>
                <td class="<?php echo e($weekArray[$day->format('w')]); ?>">
                    <?php if( $j === 0 ): ?>
                      <a href="<?php echo e(url('/task/add/' .$day->format('Y-m-d'))); ?>"><i class="glyphicon glyphicon-plus"></i></a><br/>
                    <?php endif; ?>
                    <?php if(!empty($user_task['task'][$i])): ?>
                        <?php foreach($user_task['task'][$i] as $task): ?>
                          <?php if( $j === 0 ): ?>
                            <a class="edit" href="<?php echo e(url('/task/edit/' .$task['id'])); ?>">
                              <?php echo e($task['start_time'] .'~'. $task['end_time']); ?><br/>
                              <?php echo e($task['name']); ?><br/>
                            </a>
                          <?php else: ?>
                            <?php echo e($task['start_time'] .'~'. $task['end_time']); ?><br/>
                            <?php echo e($task['name']); ?><br/>
                          <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </td>
                <?php $i++; ?>
              <?php endforeach; ?>
          </tr>
          <?php $j++; ?>
        <?php endforeach; ?>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>