<!-- text input -->
  <div class="form-group col-md-{{ $field['colspan'] or 12 }} {{ $field['cssclass'] or '' }}">
    <label>{{ $field['label'] or $field['name'] }}</label>
    <input
      type="text"
      class="form-control"
      @foreach ($field as $attribute => $value)
        @if (is_string($attribute) && is_string($value))
          @if($attribute != 'value')
            {{ $attribute }}="{{ $value }}"
          @endif
          value="{{ isset($field['value']) ? $field['value'] : old($field['name']) }}"
        @endif
      @endforeach
    >
    @if (isset($field['hint']))
      <p class="help-block" style="font-size:.9em;">{{ $field['hint'] }}</p>
    @endif
  </div>
