

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('menubar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
    <div class="panel panel-default">
      	<div class="panel-heading">
      		From : <?php echo e($sender); ?>

      	</div>
        <div class="panel-heading">
      	  To :
          <?php foreach($address_names as $address_name): ?>
              &nbsp;<?php echo e($address_name->name); ?>

          <?php endforeach; ?>
      	</div>
        <div class="panel-heading">
          <?php echo e($message->title); ?>

        </div>
      	<div class="panel-body">
          <?php echo nl2br(e($message->body)); ?>

      	</div>
    </div>

    <a class="" href="<?php echo e(url('/message/reply/' .$message->id)); ?>">
        <button type="submit" class="btn btn-danger" name="">Reply</button>
    </a>

</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>