<!-- repeater -->
  <div class="form-group col-md-{{ $field['colspan'] or 12 }} {{ $field['cssclass'] or '' }}">
    <label>{{ $field['label'] }}</label>
    {{-- <?php $entity_model = $crud->model; ?> --}}
    <vue-repeater-text
      :str-value='{!! $field['value'] or "{}" !!}'
      :field-name="'{{ $field['name'] }}'"
    >
    </vue-repeater-text>
  </div>
