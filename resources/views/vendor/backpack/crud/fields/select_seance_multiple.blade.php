<!-- select2 multiple -->
<div class="form-group col-md-{{ $field['colspan'] or 12 }}">
  <label>{{ $field['label'] }}</label>
  <vue-select-seance
    :token="'{{ csrf_token() }}'"
    :event-id="{{ isset($fields['id']) ? $fields['id']['value'] : 0 }}"
    {{-- :str-value='{!! $field['value'] or "{}" !!}' --}}
    :field-name="'{{ $field['name'] }}'"
  ></vue-select-seance>
</div>

