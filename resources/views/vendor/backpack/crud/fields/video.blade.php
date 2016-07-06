<!-- text input -->
  <div class="form-group col-md-{{ $field['colspan'] or 12 }} {{ $field['cssclass'] or '' }}">
    <label>{{ $field['label'] }}</label>
    <input
        type="text"
        class="form-control"

        @foreach ($field as $attribute => $value)
            @if (is_string($attribute) && is_string($value))
               @if($attribute == 'value')
                    {{ $attribute }}="{{ old($field['name']) ? old($field['name']) : $value }}"
                @else
                    {{ $attribute }}="{{ $value }}"
                @endif
            @endif
        @endforeach
        >
    @if (!empty($field['value']))
      <iframe width="100%" height="260" src="{{ str_replace('watch?v=', 'embed/', $field['value']) }}" frameborder="0" allowfullscreen></iframe>
    @endif
    @if (isset($field['hint']))
        <p class="help-block" style="font-size:.9em;">{{ $field['hint'] }}</p>
    @endif
  </div>
