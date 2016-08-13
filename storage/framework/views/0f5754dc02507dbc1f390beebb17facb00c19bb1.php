<!-- resources/views/tasks.blade.php -->



<?php $__env->startSection('content'); ?>

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        <?php echo $__env->make('common.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- New Task Form -->
        <form action="<?php echo e(url('task')); ?>" method="POST" class="form-horizontal">
            <?php echo e(csrf_field()); ?>


            <!-- Task Name -->
            <div class="form-group">
                <label for="task" class="col-sm-3 control-label">Task</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="task-name" class="form-control">
                </div>
            </div>

            <!-- Add Task Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Task
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Current Tasks -->
    <?php if(count($tasks) > 0): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Tasks
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Task</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        <?php foreach($tasks as $task): ?>
                            <tr>
                                <td class="table-text">
                                    <div><?php echo e($task->name); ?></div>
                                </td>
                                <td>
                                  <!-- TODO: Delete Button -->
                                  <form action="<?php echo e(url('task/'.$task->id)); ?>" method="POST">
                                      <?php echo e(csrf_field()); ?>

                                      <?php echo e(method_field('DELETE')); ?>


                                      <button type="submit" class="btn btn-danger">
                                          <i class="fa fa-trash"></i> Delete
                                      </button>
                                  </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>