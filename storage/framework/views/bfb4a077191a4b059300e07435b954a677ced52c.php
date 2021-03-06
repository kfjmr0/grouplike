<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $__env->yieldContent('meta'); ?>
    <title>GroupLike</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <style>

    </style>
</head>
<body id="app-layout">
    <nav class="mynav">
        <div class="container">
            <!-- Branding Image -->
            <a class="" href="<?php echo e(url('/')); ?>">
              <div class="mynav-title">
                    GroupLike
              </div>
            </a>
            <!-- Right Side Of Navbar -->
            <?php if(!Auth::guest()): ?>
              <div class="mynav-right">
                  <!-- Authentication Links -->
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          <i class="glyphicon glyphicon-user"></i><?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu" role="menu">
                          <li><a href="<?php echo e(url('/logout')); ?>"><i class="glyphicon glyphicon-log-out"></i>Logout</a></li>
                      </ul>
                  </li>
              </div>
            <?php endif; ?>
        </div>
    </nav>

    <div class="content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <div id="footer">
        2016.7.13 The practice of groupwarelike web application development by fjmr.
    </div>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <?php echo $__env->yieldContent('script'); ?>
    <?php /* <script src="<?php echo e(elixir('js/app.js')); ?>"></script> */ ?>
</body>
</html>
