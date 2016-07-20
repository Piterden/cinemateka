<!-- select2 multiple -->
<div class="form-group col-md-{{ $field['colspan'] or 12 }}">
  <label>{{ $field['label'] }}</label>
  <vue-select-seance
    :str-value='{!! $field['value'] !!}'
    :field-name="'{{ $field['name'] }}'"
  ></vue-select-seance>
</div>

{{-- {{ dump($fields) }} --}}
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
        {{-- <script src="{{ asset('public/js/ajax-crud.js') }}"></script> --}}
        <script>
            jQuery(document).ready(function($) {
              var addSeance = function addSeance(ev_id) {
                if (!ev_id) {
                  $.ajax({
                    url: '/admin/seance/create',
                    dataType: 'json',
                    data: {
                      event_id: ev_id
                    },
                    success: function(res) {
                      /* eslint-disable no-console */
                      console.log(res);
                      /* eslint-enable no-console */
                    },
                    error: function(res) {
                      /* eslint-disable no-console */
                      console.log(res);
                      /* eslint-enable no-console */
                    }
                  });
                }
              };
              // trigger select2 for each untriggered select2_multiple box
              $('.select2').each(function (i, obj) {
                  if (!$(obj).data("select2"))
                  {
                      $(obj).select2();
                  }
              });

              // $('#{{ $field['name'] }}-add').on('click');

            });
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
