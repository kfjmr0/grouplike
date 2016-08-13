

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('menubar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
      <form action="<?php echo e(url('/chat')); ?>" method="post">
          <?php echo e(csrf_field()); ?>

          <div class="form-group">
        		<label for="InputText">Title:</label>
            <input type="text" name="title" class="form-control" id="InputText" value="<?php echo e(old('title')); ?>">
        	</div>
        	<div class="form-group">
        		<label for="InputTextarea">First Remark:</label>
        		<textarea name="body" class="form-control" id="InputTextarea"><?php echo e(old('body')); ?></textarea>
        	</div>

        	<button type="submit" class="btn btn-danger">Create</button>
      </form>
      <?php echo $__env->make('common.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>