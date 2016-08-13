

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('menubar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
    <form action="<?php echo e(url('/message')); ?>" method="post">
        <?php echo e(csrf_field()); ?>

        <div id="address-box">To:</div>

        <div class="btn-group">
          	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          		--Select Address--
          		<span class="caret"></span>
          	</button>
          	<ul class="dropdown-menu" role="menu">
              <li id="selectAll" role="presentation"><a role="menuitem" tabindex="-1" href="#">
                ALL
              </a></li>
              <?php foreach($users as $user): ?>
                <li class="address" userid="<?php echo e($user->id); ?>" data-username="<?php echo e($user->name); ?>" role="presentation"><a role="menuitem" tabindex="-1" href="#">
                  <?php echo e($user->name); ?>

                </a></li>
              <?php endforeach; ?>
          	</ul>
        </div>

      	<div class="form-group">
      		<label for="InputText">Title:</label>
      		<input name="title" type="text" class="form-control" id="InputText" value="<?php echo e(old('title')); ?>">

      	</div>
        <div class="form-group">
      		<label for="InputTextarea">Body:</label>
      		<textarea name="body" class="form-control" id="InputTextarea" rows="10" cols="40"><?php echo e(old('body')); ?></textarea>
      	</div>

        <button type="submit" class="btn btn-danger">
          <i class="glyphicon glyphicon-send"></i>Send
        </button>
    </form>
    <?php echo $__env->make('common.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
  $(function() {
    function select() {
        $(this).off('click');
        var span = $('<span>').text($(this).data('username')).addClass('label label-primary');
        var i = $('<i>').attr('userid', $(this).attr('userid')).addClass('glyphicon glyphicon-remove');
        var hiddenform = ($('<input>').attr({
                                          type : 'hidden',
                                          name : 'addresses[]',
                                          value : $(this).attr('userid'),
                                      }));
        span.append(i).append(hiddenform);
        $('#address-box').append(span);
    };

    $('.address').click(select);

    $('#address-box').on('click', '.glyphicon-remove', function() {
        $('.address[userid="' + $(this).attr('userid') + '"]').on('click', select);
        $(this).parent().remove();
    });

    $('#selectAll').click(function() {
        $('.address').each(function() {
          $(this).trigger('click');
        });
    });
    //Hold old addresses when validation errors occur
    <?php if(null !== old('addresses')): ?>
      <?php foreach(old('addresses') as $old_address): ?>
        $('.address[userid="' + <?php echo e($old_address); ?> + '"]').trigger('click');
      <?php endforeach; ?>
    <?php endif; ?>
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>