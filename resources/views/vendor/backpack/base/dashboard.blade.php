@extends('backpack::layout')

@section('header')
<section class="content-header">
  <h1>Dashboard</h1>
  <ol class="breadcrumb">
    <li><a href="{{ 'admin' }}">{{ config('backpack.base.project_name') }}</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-header with-border">
        <div class="box-title"></div>
      </div>
      <div class="box-body">
        <div id="fullCalendar"></div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('after_scripts')
<script type="text/javascript" src="{{ asset('vendor/adminlte') }}/plugins/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#fullCalendar').fullCalendar({
      weekends: false
    });
  });
</script>
@endsection
