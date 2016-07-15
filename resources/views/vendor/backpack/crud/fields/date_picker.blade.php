<!-- Date -->
<div class="form-group col-md-{{ $field['colspan'] or 12 }}">
  <label>Date:</label>

  <div class="input-group date">
    <div class="input-group-addon">
      <i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control pull-right" id="datepicker-{{ $field['name'] }}">
  </div>
  <!-- /.input group -->
</div>
<!-- /.form group -->

<script>
  jQuery(document).ready(function($) {
      //Date picker
    $('#datepicker-{{ $field['name'] }}').each(function(i, obj) {
      $(obj).datepicker({
        autoclose: true
      });
    });
  });
</script>
