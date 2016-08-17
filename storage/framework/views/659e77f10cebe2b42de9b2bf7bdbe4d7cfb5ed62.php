<?php $__env->startSection('header'); ?>
<section class="content-header">
  <h1>Dashboard</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo e('admin'); ?>"><?php echo e(config('backpack.base.project_name')); ?></a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-header with-border">
        <div class="box-title"></div>
      </div>
      <div class="box-body">
        <vue-full-calendar
          :events="$root.fcEvents"
        ></vue-full-calendar>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backpack::layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>