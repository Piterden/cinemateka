<!-- text input -->
  <div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?> <?php echo e(isset($field['cssclass']) ? $field['cssclass'] : ''); ?>">
    <label><?php echo e(isset($field['label']) ? $field['label'] : $field['name']); ?></label>
    <input
      type="text"
      class="form-control"
      <?php foreach($field as $attribute => $value): ?>
        <?php if(is_string($attribute) && is_string($value)): ?>
          <?php if($attribute != 'value'): ?>
            <?php echo e($attribute); ?>="<?php echo e($value); ?>"
          <?php endif; ?>
          value="<?php echo e(isset($field['value']) ? $field['value'] : old($field['name'])); ?>"
        <?php endif; ?>
      <?php endforeach; ?>
    >
    <?php if(isset($field['hint'])): ?>
      <p class="help-block" style="font-size:.9em;"><?php echo e($field['hint']); ?></p>
    <?php endif; ?>
  </div>
