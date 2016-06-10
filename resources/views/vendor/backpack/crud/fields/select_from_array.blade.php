<!-- select -->
  <div class="form-group">
    <label>{{ $field['label'] }}</label>
    <select
    	class="form-control"

    	@foreach ($field as $attribute => $value)
            @if (is_string($value))
    		{{ $attribute }}="{{ $value }}"
            @endif
    	@endforeach
    	>

        @if (isset($field['allows_null']) && $field['allows_null']==true)
            <option value="">-</option>
        @endif

	    	@if (count($field['options']))
	    		@foreach ($field['options'] as $key => $value)
	    			<option value="{{ $key }}"
						@if ((isset($field['value']) && $key==$field['value']) || (old($field['name']) == $key) )
							 selected
						@endif
	    			>{{ $value }}</option>
	    		@endforeach
	    	@endif
	</select>
  </div>
