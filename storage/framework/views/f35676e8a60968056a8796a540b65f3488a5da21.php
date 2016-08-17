<!-- text input -->
  <div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?> <?php echo e(isset($field['cssclass']) ? $field['cssclass'] : ''); ?>">
    <label><?php echo e($field['label']); ?></label>
    <input
    	type="email"
    	class="form-control"

    	<?php foreach($field as $attribute => $value): ?>
            <?php if(is_string($attribute) && is_string($value)): ?>
        		<?php if($attribute == 'value'): ?>
                    <?php echo e($attribute); ?>="<?php echo e(old($field['name']) ? old($field['name']) : $value); ?>"
                <?php else: ?>
                    <?php echo e($attribute); ?>="<?php echo e($value); ?>"
                <?php endif; ?>
            <?php endif; ?>
    	<?php endforeach; ?>
    	>
  </div>
