<!-- repeater -->
  <div class="form-group col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?> <?php echo e(isset($field['cssclass']) ? $field['cssclass'] : ''); ?>">
    <label><?php echo e($field['label']); ?></label>
    {{-- <?php $entity_model = $crud->model; ?> --}}
    <vue-repeater-video
      :str-value='<?php echo isset($field['value']) ? $field['value'] : "{}"; ?>'
      :field-name="'<?php echo e($field['name']); ?>'"
    >
    </vue-repeater-video>
  </div>
