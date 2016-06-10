<!-- select2 multiple -->
  <div class="form-group">
    <label>{{ $field['label'] }}</label>
    <select
    	class="form-control select2"

    	@foreach ($field as $attribute => $value)
            @if (is_string($attribute))
        		@if ($attribute=='name')
        			{{ $attribute }}="{{ $value }}[]"
        		@else
        			{{ $attribute }}="{{ $value }}"
        		@endif
            @endif
    	@endforeach
    	multiple>
    	<option value="">-</option>

	    	@if (isset($field['model']))
	    		@foreach ($field['model']::all() as $connected_entity_entry)
	    			<option value="{{ $connected_entity_entry->id }}"
						@if ( (isset($field['value']) && in_array($connected_entity_entry->id, $field['value']->lists('id', 'id')->toArray())) || ( old( $field["name"] ) && in_array($connected_entity_entry->id, old( $field["name"])) ) )
							 selected
						@endif
	    			>{{ $connected_entity_entry->$field['attribute'] }}</option>
	    		@endforeach
	    	@endif
	</select>
  </div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include select2 css-->
        <link href="{{ asset('vendor/backpack/select2/select2.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/backpack/select2/select2-bootstrap-dick.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script src="{{ asset('vendor/backpack/select2/select2.js') }}"></script>
        <script>
            jQuery(document).ready(function($) {
                // trigger select2 for each untriggered select2_multiple box
                $('.select2').each(function (i, obj) {
                    if (!$(obj).data("select2"))
                    {
                        $(obj).select2();
                    }
                });
            });
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}