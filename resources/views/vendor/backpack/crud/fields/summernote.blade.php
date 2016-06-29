<!-- summernote editor -->
  <div class="form-group col-md-{{ $field['colspan'] or 12 }} {{ $field['cssclass'] or '' }}">
    <label>{{ $field['label'] }}</label>
    <textarea
    	class="form-control summernote"

    	@foreach ($field as $attribute => $value)
    		@if (is_string($attribute) && is_string($value))
	    		{{ $attribute }}="{{ $value }}"
    		@endif
    	@endforeach

    	>
        @if(old($field['name']))
            {{ old($field['name']) }}
        @else
            {{ ( isset($field['value']))?$field['value']:'' }}
        @endif
        </textarea>
  </div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include summernote css-->
        <link href="{{ asset('vendor/backpack/summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include summernote js-->
        <script src="{{ asset('vendor/backpack/summernote/summernote.min.js') }}"></script>
        <script>
            jQuery(document).ready(function($) {
                $('.summernote').summernote();
            });
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
