<!-- textarea -->
  <div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?> <?php echo e(isset($field['cssclass']) ? $field['cssclass'] : ''); ?>">
    <label><?php echo e($field['label']); ?></label>
    <textarea
    	class="form-control"

    	<?php foreach($field as $attribute => $value): ?>
    		<?php if(is_string($attribute) && is_string($value)): ?>
	    		<?php echo e($attribute); ?>="<?php echo e($value); ?>"
    		<?php endif; ?>
    	<?php endforeach; ?>

    	><?php echo e(old($field['name']) ? old($field['name']) : ( isset($field['value']) ? $field['value'] : '')); ?></textarea>
  </div>