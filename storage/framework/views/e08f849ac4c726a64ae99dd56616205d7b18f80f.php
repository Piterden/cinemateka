<!-- select -->
  <div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?> <?php echo e(isset($field['cssclass']) ? $field['cssclass'] : ''); ?>">
    <label><?php echo e($field['label']); ?></label>
    <?php $entity_model = $crud->model; ?>
    <select
    	class="form-control"
    	<?php foreach($field as $attribute => $value): ?>
            <?php if(is_string($value)): ?>
        		<?php echo e($attribute); ?>="<?php echo e($value); ?>"
            <?php endif; ?>
    	<?php endforeach; ?>
    	>

	    	<?php if(isset($field['model'])): ?>
	    		<?php foreach($field['model']::all() as $connected_entity_entry): ?>
	    			<option value="<?php echo e($connected_entity_entry->id); ?>"
              <?php if( ( old($field['name']) && old($field['name']) == $connected_entity_entry->id ) || (!old($field['name']) && isset($field['value']) && $connected_entity_entry->id==$field['value'])): ?>
							 selected
						<?php endif; ?>
	    			><?php echo e($connected_entity_entry->{$field['attribute']}); ?></option>
	    		<?php endforeach; ?>
	    	<?php endif; ?>
	</select>
  </div>
