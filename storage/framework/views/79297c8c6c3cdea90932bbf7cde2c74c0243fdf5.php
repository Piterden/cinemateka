<!-- CKeditor -->
  <div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?>">
    <label><?php echo e($field['label']); ?></label>
    <textarea
    	class="form-control ckeditor"
    	id="ckeditor-<?php echo e($field['name']); ?>"

    	<?php foreach($field as $attribute => $value): ?>
            <?php if(is_string($attribute) && is_string($value)): ?>
    		  <?php if($attribute == 'value'): ?>
                    <?php echo e($attribute); ?>="<?php echo e(old($field['name']) ? old($field['name']) : $value); ?>"
                <?php else: ?>
                    <?php echo e($attribute); ?>="<?php echo e($value); ?>"
                <?php endif; ?>
            <?php endif; ?>
    	<?php endforeach; ?>

    	><?php echo e(old($field['name']) ? old($field['name']) : ((isset($field['value']))?$field['value']:'')); ?></textarea>
  </div>


<?php /* ########################################## */ ?>
<?php /* Extra CSS and JS for this particular field */ ?>
<?php /* If a field type is shown multiple times on a form, the CSS and JS will only be loaded once */ ?>
<?php if($crud->checkIfFieldIsFirstOfItsType($field, $fields)): ?>

    <?php /* FIELD CSS - will be loaded in the after_styles section */ ?>
    <?php $__env->startPush('crud_fields_styles'); ?>
    <?php $__env->stopPush(); ?>

    <?php /* FIELD JS - will be loaded in the after_scripts section */ ?>
    <?php $__env->startPush('crud_fields_scripts'); ?>
        <script src="<?php echo e(asset('vendor/backpack/ckeditor/ckeditor.js')); ?>"></script>
        <script src="<?php echo e(asset('vendor/backpack/ckeditor/adapters/jquery.js')); ?>"></script>
        <script>
            jQuery(document).ready(function($) {
                $('textarea.ckeditor' ).ckeditor({
                    "filebrowserBrowseUrl": "<?php echo e(url('admin/elfinder/ckeditor')); ?>",
                    "extraPlugins" : 'oembed,widget'
                });
            });
        </script>
    <?php $__env->stopPush(); ?>

<?php endif; ?>
<?php /* End of Extra CSS and JS */ ?>
<?php /* ########################################## */ ?>
