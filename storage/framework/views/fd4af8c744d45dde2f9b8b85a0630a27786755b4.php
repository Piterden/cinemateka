<?php $__env->startSection('header'); ?>
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="<?php echo e('admin'); ?>"><?php echo e(config('backpack.base.project_name')); ?></a></li>
        <li class="active">404 error</li>
      </ol>
    </section>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="error-page">
        <h2 class="headline text-yellow text-center" style="font-size: 180px; float: none;"> 404</h2>

        <div class="text-center m-l-0">
          <h3 class="m-t-0"><i class="fa fa-warning text-yellow"></i> Page not found.</h3>

          <p>
            <?php
                $default_error_message = "Meanwhile, you may <a href='".url('admin')."'>return to dashboard</a>.";
            ?>
            <?php echo isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message; ?>

          </p>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>