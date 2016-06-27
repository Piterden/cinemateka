<!-- select2 -->
  <div class="form-group col-md-{{ $field['colspan'] or 12 }}">
    <label>{{ $field['label'] }}</label>
    <?php $entity_model = $crud->model; ?>
    <select
    	class="form-control select2"

    	@foreach ($field as $attribute => $value)
            @if (is_string($attribute))
        		{{ $attribute }}="{{ $value }}"
            @endif
    	@endforeach
    	>

    	@if ($entity_model::isColumnNullable($field['name']))
            <option value="">-</option>
        @endif

	    	@if (isset($field['model']))
	    		@foreach ($field['model']::all() as $connected_entity_entry)
	    			<option value="{{ $connected_entity_entry->id }}"
						@if ( ( old($field['name']) && old($field['name']) == $connected_entity_entry->id ) || (isset($field['value']) && $connected_entity_entry->id==$field['value']))
							 selected
						@endif
	    			>{{ $connected_entity_entry->{$field['attribute']} }}</option>
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
                // trigger select2 for each untriggered select2 box
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
