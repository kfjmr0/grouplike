

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('menubar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
  <div class="message-header">
      <div class="left">
        <a href="<?php echo e(url('/message/write')); ?>">
          <button type="button" class="btn btn-danger makeNewButton">
            <i class="glyphicon glyphicon-pencil"></i>Write Message
          </button>
        </a>
      </div>
      <div class="right">
        <a href="<?php echo e(url('/message')); ?>">
          <button type="button" class="btn btn-info makeNewButton">
            Inbox
          </button>
        </a>
      </div>
  </div>

  <table class="table message-table">
    <thead>
        <tr>
          <th>Sent Message</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; foreach($messages as $message): $__empty_1 = false; ?>
          <tr data-href="<?php echo e(url('/message/sent/' .$message->id)); ?>">
            <td>
              To:
              <?php foreach($address_names[$message->id] as $address_name): ?>
                <?php echo e($address_name->name); ?>&nbsp;
              <?php endforeach; ?>
              <br/><?php echo e($message->title); ?>

            </td>
          </tr>
        <?php endforeach; if ($__empty_1): ?>
          <tr><td>No message exists</td></tr>
        <?php endif; ?>
    </tbody>
  </table>
  <?php echo e($messages->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
  <?php echo $__env->make('table_clickable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>