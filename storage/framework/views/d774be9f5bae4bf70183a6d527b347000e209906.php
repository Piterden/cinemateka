<!-- select2 multiple -->
<div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?>">
  <label><?php echo e($field['label']); ?></label>
  <vue-select-seance
    :token="'<?php echo e(csrf_token()); ?>'"
    :event-id="<?php echo e(isset($fields['id']) ? $fields['id']['value'] : 0); ?>"
    <?php /* :str-value='<?php echo isset($field['value']) ? $field['value'] : "{}"; ?>' */ ?>
    :field-name="'<?php echo e($field['name']); ?>'"
  ></vue-select-seance>
</div>

