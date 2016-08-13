

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('menubar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
    <form action="<?php echo e(url('/message')); ?>" method="post">
        <?php echo e(csrf_field()); ?>

        <div id="address-box">To:<span class="label label-primary"><?php echo e($sender->name); ?></span></div>
        <input type="hidden" name="addresses[]" value="<?php echo e($sender->id); ?>">

      	<div class="form-group">
      		<label for="InputText">Title:</label>
      		<input name="title" type="text" class="form-control" id="InputText" value="<?php echo e(old('title', 'Re:' .$message->title)); ?>">

      	</div>
        <div class="form-group">
      		<label for="InputTextarea">Body:</label>
      		<textarea name="body" class="form-control" id="InputTextarea" rows="10" cols="40"><?php echo e(old('body', $message->body)); ?></textarea>
      	</div>

        <button type="submit" class="btn btn-danger">
          <i class="glyphicon glyphicon-send"></i>Send
        </button>
    </form>
    <?php echo $__env->make('common.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>