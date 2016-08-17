<!-- select -->
  <div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?>">
    <label><?php echo e($field['label']); ?></label>
    <select
    	class="form-control"

    	<?php foreach($field as $attribute => $value): ?>
            <?php if(is_string($value)): ?>
    		<?php echo e($attribute); ?>="<?php echo e($value); ?>"
            <?php endif; ?>
    	<?php endforeach; ?>
    	>

        <?php if(isset($field['allows_null']) && $field['allows_null']==true): ?>
            <option value="">-</option>
        <?php endif; ?>

	    	<?php if(count($field['options'])): ?>
	    		<?php foreach($field['options'] as $key => $value): ?>
	    			<option value="<?php echo e($key); ?>"
						<?php if((isset($field['value']) && $key==$field['value']) || (old($field['name']) == $key) ): ?>
							 selected
						<?php endif; ?>
	    			><?php echo e($value); ?></option>
	    		<?php endforeach; ?>
	    	<?php endif; ?>
	</select>
  </div>
