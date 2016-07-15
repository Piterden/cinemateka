<!-- time Picker -->
<div class="bootstrap-timepicker">
  <div class="form-group">
    <label>Time picker:</label>

    <div class="input-group">
      <input type="text" class="form-control timepicker" id="timepicker-{{ $field['name'] }}">

      <div class="input-group-addon">
        <i class="fa fa-clock-o"></i>
      </div>
    </div>
    <!-- /.input group -->
  </div>
  <!-- /.form group -->
</div>

<script type="text/javascript">
  jQuery(document).ready(function($) {
      //Date picker
    $('#timepicker-{{ $field['name'] }}').each(function(i, obj) {
      $(obj).datepicker({
        autoclose: true
      });
    });
  });
</script>
