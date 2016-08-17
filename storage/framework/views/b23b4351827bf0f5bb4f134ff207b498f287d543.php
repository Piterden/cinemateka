<?php $__env->startSection('header'); ?>
	<section class="content-header">
	  <h1>
	    <?php echo e(trans('backpack::crud.add')); ?> <span class="text-lowercase"><?php echo e($crud->entity_name); ?></span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="<?php echo e(url('admin/dashboard')); ?>">Admin</a></li>
	    <li><a href="<?php echo e(url($crud->route)); ?>" class="text-capitalize"><?php echo e($crud->entity_name_plural); ?></a></li>
	    <li class="active"><?php echo e(trans('backpack::crud.add')); ?></li>
	  </ol>
	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-12">

    <?php echo Form::open([
      'url' => $crud->route,
      'method' => 'post',
      'id' => 'entry-form',
      'class' => $crud->entity_name.'-edit-form',
    ]); ?>

      <div class="box">

        <div class="box-header with-border">
      		<!-- Default box -->
      		<div class="col-md-4">
            <?php if($crud->hasAccess('list')): ?>
        			<a href="<?php echo e(url($crud->route)); ?>"><i class="fa fa-angle-double-left"></i> <?php echo e(trans('backpack::crud.back_to_all')); ?> <span class="text-lowercase"><?php echo e($crud->entity_name_plural); ?></span></a><br><br>
        		<?php endif; ?>
          </div>
          <div class="box-actions col-md-8 text-right">
            <div class="form-inline hidden">
              <span>После сохранения:</span>
              <div class="radio">
                <label>
                  <input type="radio" name="redirect_after_save" value="<?php echo e($crud->route); ?>">
                  список всех элементов
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="redirect_after_save" value="<?php echo e($crud->route.'/create'); ?>">
                  добавить еще
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="redirect_after_save" value="current_item_edit" checked="">
                  <?php echo e(trans('backpack::crud.edit_the_new_item')); ?>

                </label>
              </div>
            </div>
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
            <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> <?php echo e(trans('backpack::crud.add')); ?></span></button>
            <a href="<?php echo e(url($crud->route)); ?>" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label"><?php echo e(trans('backpack::crud.cancel')); ?></span></a>

          </div><!-- /.box-actions-->

  	    </div>
  	    <div class="box-body row">
  	      <!-- load the view from the application if it exists, otherwise load the one in the package -->
  	      <?php if(view()->exists('vendor.backpack.crud.form_content')): ?>
  	      	<?php echo $__env->make('vendor.backpack.crud.form_content', ['fields' => $crud->getFields('create')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  	      <?php else: ?>
  	      	<?php echo $__env->make('crud::form_content', ['fields' => $crud->getFields('create')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  	      <?php endif; ?>
  	    </div><!-- /.box-body -->
  	    <div class="box-footer">
  	    	<?php /* <div class="form-group">
  	    	  <span><?php echo e(trans('backpack::crud.after_saving')); ?>:</span>
	          <div class="radio">
	            <label>
	              <input type="radio" name="redirect_after_save" value="<?php echo e($crud->route); ?>">
	              <?php echo e(trans('backpack::crud.go_to_the_table_view')); ?>

	            </label>
	          </div>
	          <div class="radio">
	            <label>
	              <input type="radio" name="redirect_after_save" value="<?php echo e($crud->route.'/create'); ?>">
	              <?php echo e(trans('backpack::crud.let_me_add_another_item')); ?>

	            </label>
	          </div>
	          <div class="radio">
	            <label>
	              <input type="radio" name="redirect_after_save" value="current_item_edit" checked="">
	              <?php echo e(trans('backpack::crud.edit_the_new_item')); ?>

	            </label>
	          </div>
	        </div>
    		  <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
    		  <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> <?php echo e(trans('backpack::crud.add')); ?></span></button>
  	      <a href="<?php echo e(url($crud->route)); ?>" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label"><?php echo e(trans('backpack::crud.cancel')); ?></span></a> */ ?>
  	    </div><!-- /.box-footer-->

  	  </div><!-- /.box -->
	  <?php echo Form::close(); ?>

	</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backpack::layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>