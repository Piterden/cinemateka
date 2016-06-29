<!-- browse server input -->
<div class="form-group col-md-{{ $field['colspan'] or 12 }} {{ $field['cssclass'] or '' }}">
  <label>{{ $field['label'] }}</label>
	<input
		type="text"
		class="form-control"
		id="{{ $field['name'] }}-filemanager"
      @foreach ($field as $attribute => $value)
        @if (is_string($attribute) && is_string($value))
    			{{ $attribute }}="{{ $value }}"
  			@endif
  		@endforeach

		readonly
	>

	<div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
	  <button type="button" data-inputid="{{ $field['name'] }}-filemanager" class="btn btn-default popup_selector">
  		<i class="fa fa-cloud-upload"></i> Browse uploads
    </button>
		<button type="button" data-inputid="{{ $field['name'] }}-filemanager" class="btn btn-default clear_elfinder_picker">
  		<i class="fa fa-eraser"></i> Clear
    </button>
	</div>

</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

	{{-- FIELD CSS - will be loaded in the after_styles section --}}
	@push('crud_fields_styles')
		<!-- include browse server css -->
		<link href="{{ asset('vendor/backpack/colorbox/example2/colorbox.css') }}" rel="stylesheet" type="text/css" />
	@endpush

	{{-- FIELD JS - will be loaded in the after_scripts section --}}
	@push('crud_fields_scripts')
		<!-- include browse server js -->
		<script src="{{ asset('vendor/backpack/colorbox/jquery.colorbox-min.js') }}"></script>
		<script src="{{ asset('vendor/backpack/elfinder/standalonepopup.js') }}"></script>
	@endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
