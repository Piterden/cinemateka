<!-- select -->
  <div class="form-group">
    <label>{{ $field['label'] }}</label>
    <?php $entity_model = $crud->model; ?>
    <select
    	class="form-control"

    	@foreach ($field as $attribute => $value)
            @if (is_string($value))
        		{{ $attribute }}="{{ $value }}"
            @endif
    	@endforeach
    	>

            <option value="">-</option>

	    	@if (isset($field['model']))

	    		@foreach ($field['model']::all() as $connected_entity_entry)
	    			<option value="{{ $connected_entity_entry->id }}"

                        @if ( ( old($field['name']) && old($field['name']) == $connected_entity_entry->id ) || (!old($field['name']) && isset($field['value']) && $connected_entity_entry->id==$field['value']))

							 selected
						@endif
	    			>{{ $connected_entity_entry->{$field['attribute']} }}</option>
	    		@endforeach
	    	@endif
	</select>
  </div>
