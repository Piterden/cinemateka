<!-- repeater -->
  <div class="form-group col-md-{{ $field['colspan'] or 12 }} {{ $field['cssclass'] or '' }}">
    <label>{{ $field['label'] }}</label>
    {{-- <?php $entity_model = $crud->model; ?> --}}
    <vue-repeater-image
      :str-value='{!! $field['value'] or "{}" !!}'
      :field-name="'{{ $field['name'] }}'"
    >
    </vue-repeater-image>
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
  @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
