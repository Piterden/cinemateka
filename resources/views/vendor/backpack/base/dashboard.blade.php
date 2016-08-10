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
        <vue-full-calendar
          :events="$root.fcEvents"
        ></vue-full-calendar>
      </div>
    </div>
  </div>
</div>
@endsection

