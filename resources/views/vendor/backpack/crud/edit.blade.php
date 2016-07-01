@extends('backpack::layout')

@section('header')
  <section class="content-header">
    <h1>
      {{ trans('backpack::crud.edit') }} <span class="text-lowercase">{{ $crud->entity_name }}</span>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard') }}">Admin</a></li>
      <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
      <li class="active">{{ trans('backpack::crud.edit') }}</li>
    </ol>
  </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <!-- Default box -->

      {!! Form::open([
        'id' => 'entry-form',
        'url' => $crud->route.'/'.$entry->id,
        'method' => 'put',
        'class' => $crud->entity_name.'-edit-form',
        //'@submit' => '$root.submitEditForm($event)'
      ]) !!}
      <div class="box">
        <div class="box-header with-border">
          <div class="box-title col-md-6" style="line-height: 1.9">
            @if ($crud->hasAccess('list'))
              <a href="{{ url($crud->route) }}">
                <i class="fa fa-angle-double-left"></i>
                {{ trans('backpack::crud.back_to_all') }}
                <span class="text-lowercase">
                  {{ $crud->entity_name_plural }}
                </span>
              </a>
            @endif
          </div><!-- /.box-title-->
          <div class="box-actions col-md-6 text-right">
            <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in">
              <span class="ladda-label">
                <i class="fa fa-save"></i>
                {{ trans('backpack::crud.save') }}
              </span>
            </button><!-- /.top-submit-button-->
            <a href="{{ url($crud->route) }}" class="btn btn-default ladda-button" data-style="zoom-in">
              <span class="ladda-label">
                <i class="fa fa-ban"></i>
                {{ trans('backpack::crud.cancel') }}
              </span>
            </a><!-- /.top-submit-button-->
          </div><!-- /.box-actions-->
        </div>
        <div class="box-body row">
          <!-- load the view from the application if it exists, otherwise load the one in the package -->
          @if(view()->exists('vendor.dick.crud.form_content'))
            @include('vendor.dick.crud.form_content')
          @else
            @include('crud::form_content', ['fields' => $crud->getFields('update', $entry->id)])
          @endif
        </div><!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in">
            <span class="ladda-label">
              <i class="fa fa-save"></i>
              {{ trans('backpack::crud.save') }}
            </span>
          </button><!-- /.bottom-submit-button-->
          <a href="{{ url($crud->route) }}" class="btn btn-default ladda-button" data-style="zoom-in">
            <span class="ladda-label">
              {{ trans('backpack::crud.cancel') }}
            </span>
          </a><!-- /.bottom-cancel-button-->
        </div><!-- /.box-footer-->
      </div><!-- /.box -->
      {!! Form::close() !!}
  </div>
</div>
@endsection
