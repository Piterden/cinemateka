<!-- summernote editor -->
  <div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?> <?php echo e(isset($field['cssclass']) ? $field['cssclass'] : ''); ?>">
    <label><?php echo e($field['label']); ?></label>
    <textarea
    	class="form-control summernote"

    	<?php foreach($field as $attribute => $value): ?>
    		<?php if(is_string($attribute) && is_string($value)): ?>
	    		<?php echo e($attribute); ?>="<?php echo e($value); ?>"
    		<?php endif; ?>
    	<?php endforeach; ?>

    	>
        <?php if(old($field['name'])): ?>
            <?php echo e(old($field['name'])); ?>

        <?php else: ?>
            <?php echo e(( isset($field['value']))?$field['value']:''); ?>

        <?php endif; ?>
        </textarea>
  </div>


<?php /* ########################################## */ ?>
<?php /* Extra CSS and JS for this particular field */ ?>
<?php /* If a field type is shown multiple times on a form, the CSS and JS will only be loaded once */ ?>
<?php if($crud->checkIfFieldIsFirstOfItsType($field, $fields)): ?>

    <?php /* FIELD CSS - will be loaded in the after_styles section */ ?>
    <?php $__env->startPush('crud_fields_styles'); ?>
        <!-- include summernote css-->
        <link href="<?php echo e(asset('vendor/backpack/summernote/summernote.css')); ?>" rel="stylesheet" type="text/css" />
    <?php $__env->stopPush(); ?>

    <?php /* FIELD JS - will be loaded in the after_scripts section */ ?>
    <?php $__env->startPush('crud_fields_scripts'); ?>
        <!-- include summernote js-->
        <script src="<?php echo e(asset('vendor/backpack/summernote/summernote.min.js')); ?>"></script>
        <script>
            jQuery(document).ready(function($) {
                $('.summernote').summernote();
            });
        </script>
    <?php $__env->stopPush(); ?>

<?php endif; ?>
<?php /* End of Extra CSS and JS */ ?>
<?php /* ########################################## */ ?>
