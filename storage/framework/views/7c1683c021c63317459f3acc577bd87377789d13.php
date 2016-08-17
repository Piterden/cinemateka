<!-- browse server input -->
<div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?> <?php echo e(isset($field['cssclass']) ? $field['cssclass'] : ''); ?>">
  <label><?php echo e($field['label']); ?></label>
	<input
		type="text"
		class="form-control"
		id="<?php echo e($field['name']); ?>-filemanager"
      <?php foreach($field as $attribute => $value): ?>
        <?php if(is_string($attribute) && is_string($value)): ?>
    			<?php echo e($attribute); ?>="<?php echo e($value); ?>"
  			<?php endif; ?>
  		<?php endforeach; ?>

		readonly
	>

  <?php if(isset($field['value'])): ?>
    <img src="/<?php echo e($field['value']); ?>" style="width:100%">
  <?php endif; ?>

	<div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
	  <button type="button" data-inputid="<?php echo e($field['name']); ?>-filemanager" class="btn btn-default popup_selector">
  		<i class="fa fa-cloud-upload"></i> Browse uploads
    </button>
		<button type="button" data-inputid="<?php echo e($field['name']); ?>-filemanager" class="btn btn-default clear_elfinder_picker">
  		<i class="fa fa-eraser"></i> Clear
    </button>
	</div>

</div>

<?php /* ########################################## */ ?>
<?php /* Extra CSS and JS for this particular field */ ?>
<?php /* If a field type is shown multiple times on a form, the CSS and JS will only be loaded once */ ?>
<?php if($crud->checkIfFieldIsFirstOfItsType($field, $fields)): ?>

	<?php /* FIELD CSS - will be loaded in the after_styles section */ ?>
	<?php $__env->startPush('crud_fields_styles'); ?>
		<!-- include browse server css -->
		<link href="<?php echo e(asset('vendor/backpack/colorbox/example2/colorbox.css')); ?>" rel="stylesheet" type="text/css" />
	<?php $__env->stopPush(); ?>

	<?php /* FIELD JS - will be loaded in the after_scripts section */ ?>
	<?php $__env->startPush('crud_fields_scripts'); ?>
		<!-- include browse server js -->
		<script src="<?php echo e(asset('vendor/backpack/colorbox/jquery.colorbox-min.js')); ?>"></script>
		<script src="<?php echo e(asset('vendor/backpack/elfinder/standalonepopup.js')); ?>"></script>
	<?php $__env->stopPush(); ?>

<?php endif; ?>
<?php /* End of Extra CSS and JS */ ?>
<?php /* ########################################## */ ?>
