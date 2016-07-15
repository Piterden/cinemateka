<!-- html5 datetime input -->
  <div class="form-group col-md-{{ $field['colspan'] or 12 }}">
    <label>{{ $field['label'] }}</label>
    <input
        type="datetime-local"
        class="form-control"

        @foreach ($field as $attribute => $value)
            @if (is_string($attribute) && is_string($value))
                @if ($attribute == 'value')
                    value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime(old($field['name']) ? old($field['name']) : $value )) }}"
                @else
                    {{ $attribute }}="{{ $value }}"
                @endif
            @endif
        @endforeach
        >
  </div>
