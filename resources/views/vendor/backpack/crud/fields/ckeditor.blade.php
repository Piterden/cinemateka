<!-- CKeditor -->
  <div class="form-group col-md-{{ $field['colspan'] or 12 }}">
    <label>{{ $field['label'] }}</label>
    <textarea
    	class="form-control ckeditor"
    	id="ckeditor-{{ $field['name'] }}"

    	@foreach ($field as $attribute => $value)
            @if (is_string($attribute) && is_string($value))
    		  @if($attribute == 'value')
                    {{ $attribute }}="{{ old($field['name']) ? old($field['name']) : $value }}"
                @else
                    {{ $attribute }}="{{ $value }}"
                @endif
            @endif
    	@endforeach

    	>{{ old($field['name']) ? old($field['name']) : ((isset($field['value']))?$field['value']:'')  }}</textarea>
  </div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script src="{{ asset('vendor/backpack/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/backpack/ckeditor/adapters/jquery.js') }}"></script>
        <script>
            jQuery(document).ready(function($) {
                $('textarea.ckeditor' ).ckeditor({
                    "filebrowserBrowseUrl": "{{ url('admin/elfinder/ckeditor') }}",
                    "extraPlugins" : 'oembed,widget'
                });
            });
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
