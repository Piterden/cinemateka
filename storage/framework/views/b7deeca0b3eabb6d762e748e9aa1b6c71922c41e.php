<!-- checkbox field -->
<div class="checkbox col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?> <?php echo e(isset($field['cssclass']) ? $field['cssclass'] : ''); ?>">
	<label>
	  <input type="hidden" name="<?php echo e($field['name']); ?>" value="0">
	  <input type="checkbox" value="1" <?php foreach($field as $attribute => $value): ?>
        <?php if(is_string($attribute) ): ?>
    		<?php if( $attribute == 'value' ): ?>
    			<?php if( ((int) $value == 1 || old($field['name']) == 1) && old($field['name']) !== '0' ): ?>
    			 checked = "checked"
    			<?php endif; ?>

    		<?php else: ?>
    			<?php echo e($attribute); ?>="<?php echo e($value); ?>"
    		<?php endif; ?>
        <?php endif; ?>
	<?php endforeach; ?>> <?php echo e($field['label']); ?>

	</label>
</div>
