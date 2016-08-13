

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('menubar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
      <a href="<?php echo e(url('/chat/new')); ?>">
        <button type="button" class="btn btn-danger makeNewButton">
          <i class="glyphicon glyphicon-plus-sign"></i>Create New Topic
        </button>
      </a>

      <div class="topic-container">
        <?php $__empty_1 = true; foreach($headlines as $headline): $__empty_1 = false; ?>
          <a href="<?php echo e(url('/chat/' .$headline->id)); ?>">
              <div class="panel panel-info">
                <div class="panel-heading title">
                  <?php echo e($headline->title); ?>

                  <?php if($unreads[$headline->id] > 0): ?>
                    <span class="badge"><?php echo e($unreads[$headline->id]); ?></span>
                  <?php endif; ?>
                </div>
                <div class="panel-body">
                  <?php echo e($headline->body); ?>

                </div>
              </div>
          </a>
        <?php endforeach; if ($__empty_1): ?>
          No Topic Exists
        <?php endif; ?>
      </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>