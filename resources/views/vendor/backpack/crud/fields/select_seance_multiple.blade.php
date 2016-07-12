<!-- select2 multiple -->
<div class="form-group col-md-{{ $field['colspan'] or 12 }}">
  <label>{{ $field['label'] }}</label>
  <select
    class="form-control select2"

    @set('event_id', isset($fields['id']) ? $fields['id']['value'] : 0)
    @set('seances_coll', $field['model']::where('event_id', '=', $event_id)->get())

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
        @foreach ($seances_coll as $connected_entity_entry)
          <option value="{{ $connected_entity_entry->id }}"
          @if ( (isset($field['value']) && in_array($connected_entity_entry->id, $field['value']->lists('id', 'id')->toArray())) || ( old( $field['name'] ) && in_array($connected_entity_entry->id, old( $field['name'])) ) )
             selected
          @endif
          >{{ $connected_entity_entry->$field['attribute'] }}</option>
        @endforeach
      @endif
  </select>
  <button class="btn btn-primary"
    id="{{ $field['name'] }}-add"
    data-event-id="{{ $event_id }}"
  >
    {{ $field['add_label'] }}
  </button>
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

              $('#{{ $field['name'] }}-add').on('click', function(e) {
                e.preventDefault();
                var $this = $(this),
                  event_id = $this.data('event_id')
                $.colorbox({href:'/admin/seance/create'});
                return false;
              });

            });
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
