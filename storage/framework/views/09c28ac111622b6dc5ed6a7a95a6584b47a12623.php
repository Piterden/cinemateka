<!-- number input -->
  <div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?>">
    <label><?php echo e($field['label']); ?></label>
    <input
    	type="number"
    	class="form-control"
        step="<?php echo e(isset($field['step']) ? $field['step'] : 1); ?>"

    	<?php foreach($field as $attribute => $value): ?>
            <?php if(is_string($attribute)): ?>
        		<?php if($attribute == 'value'): ?>
                        <?php echo e($attribute); ?>="<?php echo e(old($field['name']) ? old($field['name']) : $value); ?>"
                <?php else: ?>
                    <?php echo e($attribute); ?>="<?php echo e($value); ?>"
                <?php endif; ?>
            <?php endif; ?>
    	<?php endforeach; ?>
    	>
  </div>
