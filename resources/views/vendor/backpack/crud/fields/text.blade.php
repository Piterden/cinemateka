<!-- text input -->
  <div class="form-group col-md-{{ $field['colspan'] or 12 }} {{ $field['cssclass'] or '' }}">
    <label>{{ $field['label'] }}</label>
    <input
        type="text"
        class="form-control"

        @foreach ($field as $attribute => $value)
            @if (is_string($attribute) && is_string($value))
               @if($attribute == 'value')
                    {{ $attribute }}="{{ old($field['name']) ? old($field['name']) : $value }}"
                @else
                    {{ $attribute }}="{{ $value }}"
                @endif
            @endif
        @endforeach
        >
    @if (isset($field['hint']))
        <p class="help-block" style="font-size:.9em;">{{ $field['hint'] }}</p>
    @endif
  </div>

@if($field['name'] == 'title')
  <script type="text/javascript">
    Vue.extend({
      data() {
        return {
          title: {{ $field['value'] }}
        }
      }
    });
  </script>
@endif
