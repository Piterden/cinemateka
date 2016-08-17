<div class="navbar-custom-menu pull-left">
    <ul class="nav navbar-nav">
        <!-- =================================================== -->
        <!-- ========== Top menu items (ordered left) ========== -->
        <!-- =================================================== -->

        <!-- <li><a href="<?php echo e(url('/')); ?>"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

        <!-- ========== End of top menu left items ========== -->
    </ul>
</div>


<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- ========================================================= -->
      <!-- ========== Top menu right items ========== -->
      <!-- ========================================================= -->

      <!-- <li><a href="<?php echo e(url('/')); ?>"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

        <?php if(Auth::guest()): ?>
            <li><a href="<?php echo e(url('admin/login')); ?>">Login</a></li>
            <li><a href="<?php echo e(url('admin/register')); ?>">Register</a></li>
        <?php else: ?>
            <li><a href="<?php echo e(url('admin/logout')); ?>"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
        <?php endif; ?>

       <!-- ========== End of top menu right items ========== -->
    </ul>
</div>
