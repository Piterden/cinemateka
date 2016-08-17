<!-- hidden input -->
  <div class="form-group">
    <input
    	type="hidden"
    	class="form-control"

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