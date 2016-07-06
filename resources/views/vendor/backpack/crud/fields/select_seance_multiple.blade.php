<!-- select2 multiple -->
<div class="form-group col-md-{{ $field['colspan'] or 12 }}">
  <label>{{ $field['label'] }}</label>
  <select class="form-control select2"
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
    @if (isset($field['model']))
      {{-- @foreach ($seances->where('event_id', $entry->id) as $seance) --}}
        {{-- <option
          value="{{ $seance->id }}"
          @if ( (isset($field[ 'value']) && in_array($seance->id, $field['value']->lists('id', 'id')->toArray())) || ( old( $field["name"] ) && in_array($seance->id, old( $field["name"])) ) )
            selected
          @endif >
          {{ $seance->$field['attribute'] }}
        </option> --}}
      {{-- @endforeach --}}
    @endif
  </select>
  <pre>
    {{-- {{ var_dump($seances->where('event_id', 1)->toArray()) }} --}}
  </pre>
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
        $('.select2').each(function(i, obj) {
          if (!$(obj).data("select2")) {
            $(obj).select2();
          }
        });
      });
    </script>
  @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
