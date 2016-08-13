

<?php echo $__env->yieldContent('date_setting'); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('menubar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
  <div class="add-task">
    <form class="task-form" action="<?php echo $__env->yieldContent('action'); ?>" method="post">
      <?php echo e(csrf_field()); ?>

      <?php echo $__env->yieldContent('http_method'); ?>

      <div class="ymd-input">
        <div class="ib">
          <div class="date-input">
            <label class="" for="InputYear">Y:</label>
            <select name="year" id="InputYear">
              <option value="<?php echo e($date->format('Y')); ?>"><?php echo e($date->format('Y')); ?></option>
              <option value="<?php echo e($date->format('Y') + 1); ?>"><?php echo e($date->format('Y') + 1); ?></option>
            </select>
          </div>
          <div class="date-input">
              <label class="" for="InputMonth">M:</label>
              <select name="month" id="InputMonth">
                <?php for($i = 1; $i < 13; $i++): ?>
                  <?php if("$i" === $selected_month): ?>
                   <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                  <?php else: ?>
                   <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                  <?php endif; ?>
                <?php endfor; ?>
              </select>
          </div>
          <div class="date-input">
              <label class="" for="InputDay">D:</label>
              <select name="day" id="InputDay">
                <?php for($i = 1; $i <= $last_day; $i++): ?>
                  <?php if("$i" === $selected_day): ?>
                   <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                  <?php else: ?>
                   <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                  <?php endif; ?>
                <?php endfor; ?>
              </select>
          </div>
        </div>
      </div>


      <div class="start_time">
        <div class="ib">
            <div class="date-input">
                <label class="" for="InputStartHour">Start :</label>
                <select name="startHour" id="InputStartHour">
                  <?php for($i = 0; $i < 24; $i++): ?>
                    <?php if($i === $selected_start_hour): ?>
                     <option value="<?php echo e($i); ?>" selected><?php echo e(sprintf("%02d", $i)); ?></option>
                    <?php else: ?>
                     <option value="<?php echo e($i); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                    <?php endif; ?>
                  <?php endfor; ?>
                </select>
              </div>
            <div class="date-input">:</div>
            <div class="date-input">
                <select name="startMinute" id="InputStartMinute">
                  <?php for($i = 0; $i < 60; $i += 10): ?>
                    <?php if($i === $selected_start_minute): ?>
                     <option value="<?php echo e($i); ?>" selected><?php echo e(sprintf("%02d", $i)); ?></option>
                    <?php else: ?>
                     <option value="<?php echo e($i); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                    <?php endif; ?>
                  <?php endfor; ?>
                </select>
            </div>
        </div>
      </div>
      <div class="end_time">
        <div class="ib">
            <div class="date-input">
                <label for="InputEndHour">End :&nbsp;&nbsp;</label>
                <select name="endHour" id="InputEndHour">
                  <?php for($i = $selected_start_hour; $i < 24; $i++): ?>
                    <?php if($i === $selected_end_hour): ?>
                     <option value="<?php echo e($i); ?>" selected><?php echo e(sprintf("%02d", $i)); ?></option>
                    <?php else: ?>
                     <option value="<?php echo e($i); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                    <?php endif; ?>
                  <?php endfor; ?>
                </select>
            </div>
            <div class="date-input">:</div>
            <div class="date-input">
                <select name="endMinute" id="InputEndMinute">
                  <?php for($i = 0; $i < 60; $i += 10): ?>
                    <?php if($i === $selected_end_minute): ?>
                     <option value="<?php echo e($i); ?>" selected><?php echo e(sprintf("%02d", $i)); ?></option>
                    <?php else: ?>
                     <option value="<?php echo e($i); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                    <?php endif; ?>
                  <?php endfor; ?>
                </select>
            </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-1 control-label" for="InputTask">Task:</label>
        <div class="col-sm-11">
          <input type="text" name="task_name" class="form-control" id="InputTask" value="<?php echo $__env->yieldContent('task_name'); ?>">
        </div>
      </div>

      <?php echo $__env->yieldContent('submit_button'); ?>

    </form>
    <?php echo $__env->make('common.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldContent('delete_button'); ?>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
  <?php echo $__env->make('task.layouts.checkDate_script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>