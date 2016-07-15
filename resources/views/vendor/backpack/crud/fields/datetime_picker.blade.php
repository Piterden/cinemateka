<!-- html5 datetime input -->
@set('col', $field['colspan'] or 12)


<div class="datetime-picker col-md-{{ $col }}" id="datetime-{{ $field['name'] }}">
  <vue-datetime-picker class="vue-picker2" name="picker2"
    model="'{{ strftime('%d %B %G', strtotime(old($field['name']))) }}'"
    type="datetime"
    language="en"
    datetime-format="LLL"
  ></vue-datetime-picker>
  {{-- <input
    id="datetime-{{ $field['name'] }}"
    type="hidden"
    class="form-control"
    @foreach ($field as $attribute => $value)
      @if (is_string($attribute) && is_string($value))
        @if ($attribute == 'value')
          value="datetime"
        @else
          {{ $attribute }}="{{ $value }}"
        @endif
      @endif
    @endforeach
    >
  <div class="form-group col-md-{{ $col }}">
    <label>{{ $field['label'] }}</label>
    <div class="input-group date">
      <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </div>
      <input type="text"
        class="form-control pull-right"
        id="datepicker-{{ $field['name'] }}"
        value="{{ strftime('%d %B %G', strtotime(old($field['name']))) }}">
    </div>
    <div class="bootstrap-timepicker">
      <div class="input-group">
        <input type="text"
          class="form-control pull-right"
          id="timepicker-{{ $field['name'] }}"
          value="{{ strftime('%Y-%m-%d', strtotime(old($field['name']))) }}">
        <div class="input-group-addon">
          <i class="fa fa-clock-o"></i>
        </div>
      </div>
    </div>
  </div> --}}
</div>
<script>


  // jQuery(document).ready(function($) {
  //   $('#datepicker-{{ $field['name'] }}').datepicker({
  //     autoclose: true,
  //     startDate: new Date(),
  //     format: 'dd MM yyyy'
  //   }).on('changeDate', function(e) {
  //     var t = $('#timepicker-{{ $field['name'] }}').val(),
  //       a = t.split(':');
  //       e.date.setHours(a[0], a[1]);

  //   });
  //   $('#timepicker-{{ $field['name'] }}').timepicker({
  //     showInputs: false,
  //     minuteStep: 5,
  //     showMeridian: false
  //   }).on('changeTime.timepicker', function(e) {
  //     var dp = $('#datepicker-{{ $field['name'] }}').val(),
  //       new Date(e.timeStamp);

  //   });
  // });
</script>
