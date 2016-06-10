<!-- html5 date input -->
  <div class="form-group">
    <label>{{ $field['label'] }}</label>
    <input
        type="date"
        class="form-control"

        @foreach ($field as $attribute => $value)
            @if (is_string($attribute) && is_string($value))
                @if ($attribute=='value')
                    value="{{ old($field['name']) ? old($field['name']) : $value }}"
                @else
                    {{ $attribute }}="{{ $value }}"
                @endif
            @endif
        @endforeach
        >
  </div>
