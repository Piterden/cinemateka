<!-- enum -->
  <div class="form-group">
    <label>{{ $field['label'] }}</label>
    <?php $entity_model = $crud->model; ?>
    <select
    	class="form-control"

    	@foreach ($field as $attribute => $value)
            @if (is_string($attribute) && is_string($value))
        		{{ $attribute }}="{{ $value }}"
            @endif
    	@endforeach
    	>

        @if ($entity_model::isColumnNullable($field['name']))
            <option value="">-</option>
        @endif

	    	@if (count($entity_model::getPossibleEnumValues($field['name'])))
	    		@foreach ($entity_model::getPossibleEnumValues($field['name']) as $possible_value)
	    			<option value="{{ $possible_value }}"
						@if (( old($field['name']) &&  old($field['name']) == $possible_value) || (isset($field['value']) && $field['value']==$possible_value))
							 selected
						@endif
	    			>{{ $possible_value }}</option>
	    		@endforeach
	    	@endif
	</select>
  </div>