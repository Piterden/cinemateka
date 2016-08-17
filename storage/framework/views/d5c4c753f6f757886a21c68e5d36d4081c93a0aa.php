<form role="form">
  <?php /* Show the erros, if any */ ?>
  <?php if($errors->any()): ?>
  	<div class="callout callout-danger">
      <h4>Ошибка!</h4>
      <ul>
    		<?php foreach($errors->all() as $error): ?>
    			<li><?php echo e($error); ?></li>
    		<?php endforeach; ?>
  		</ul>
  	</div>
  <?php endif; ?>

  <?php /* Show the inputs */ ?>
  <?php foreach($fields as $field): ?>
    <!-- load the view from the application if it exists, otherwise load the one in the package -->
  	<?php if(view()->exists('vendor.dick.crud.fields.'.$field['type'])): ?>
  		<?php echo $__env->make('vendor.dick.crud.fields.'.$field['type'], array('field' => $field), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  	<?php else: ?>
  		<?php echo $__env->make('crud::fields.'.$field['type'], array('field' => $field), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  	<?php endif; ?>
  <?php endforeach; ?>
</form>

<?php /* Define blade stacks so css and js can be pushed from the fields to these sections. */ ?>

<?php $__env->startSection('after_styles'); ?>
	<!-- CRUD FORM CONTENT - crud_fields_styles stack -->
	<?php echo $__env->yieldPushContent('crud_fields_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<!-- CRUD FORM CONTENT - crud_fields_scripts stack -->
	<?php echo $__env->yieldPushContent('crud_fields_scripts'); ?>
<?php $__env->stopSection(); ?>
