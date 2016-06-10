<!-- password -->
  <div class="form-group">
    <label>{{ $field['label'] }}</label>
    <input
    	type="password"
    	class="form-control"

    	@foreach ($field as $attribute => $value)
            @if (is_string($attribute) && is_string($value) && $attribute!='value')
        		{{ $attribute }}="{{ $value }}"
            @endif
    	@endforeach
    	>
  </div>