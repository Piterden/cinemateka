<!-- repeater -->
  <div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?> <?php echo e(isset($field['cssclass']) ? $field['cssclass'] : ''); ?>">
    <label><?php echo e($field['label']); ?></label>
    {{-- <?php $entity_model = $crud->model; ?> --}}
    <vue-repeater-image
      :str-value='<?php echo isset($field['value']) ? $field['value'] : "{}"; ?>'
      :field-name="'<?php echo e($field['name']); ?>'"
    >
    </vue-repeater-image>
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
  <?php $__env->stopPush(); ?>

<?php endif; ?>
<?php /* End of Extra CSS and JS */ ?>
<?php /* ########################################## */ ?>
