@extends('crud::crud')

@section('after_styles')
    @parent

    {!! Html::style('plugins/select2/select2.min.css') !!}
@stop

@section('content')
	@include('crud::layouts.head')

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			@if (/*$curd->checkPermission('list')*/true)
				<a href="{{ url($crud->getRoute()) }}"><i class="fa fa-angle-double-left"></i> @lang('crud::crud.list.back')</a><br><br>
			@endif

			{!! Form::open(['url' => $crud->getRoute().'/'.$crud->item->id, 'method' => 'put', 'files' => true, 'autocomplete' => 'false']) !!}
			  	<div class="box box-primary">
			    	<div class="box-header with-border">
			      		<h3 class="box-title">@lang('crud::crud.form.edit')</h3>
			      		@include('crud::layouts.tabs')
			    	</div>
			    	<div class="box-body">
			    		@include('crud::alerts.errors')
			    		@include('crud::alerts.success')
			      		@include('crud::layouts.form')
			    	</div><!-- /.box-body -->
			    	<div class="box-footer">
						@include('crud::layouts.buttons')
			    	</div><!-- /.box-footer-->
			  	</div><!-- /.box -->
			{!! Form::close() !!}
		</div>
	</div>
@stop

@section('after_scripts')
    @parent

    {!! Html::script('plugins/select2/select2.full.min.js') !!}
    {!! Html::script('plugins/select2/i18n/'.config()->get('app.locale').'.js') !!}
    {!! Html::script('plugins/ckeditor/ckeditor.js') !!}
    {!! Html::script('plugins/ckeditor/adapters/jquery.js') !!}
    {!! Html::script('js/crud.js') !!}
@stop
