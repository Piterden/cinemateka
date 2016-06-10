@extends('crud::crud')

@section('content')
	@include('crud::layouts.head')

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			@if (/*$curd->checkPermission('list')*/true)
				<a href="{{ url($crud->getRoute()) }}"><i class="fa fa-angle-double-left"></i> @lang('crud::crud.list.back')</a><br><br>
			@endif

		  	<div class="box box-primary">
		    	<div class="box-header with-border">
		      		<h3 class="box-title">@lang('crud::crud.form.view')</h3>
		      		@include('crud::layouts.tabs')
		    	</div>
		    	<div class="box-body">
					@foreach ($crud->fields() as $field)
						<div class="form-group">
							<label>{{ $field['label'] or $crud->labels()[$field['name']] }}:</label>
							<div>
								@if ($field['type'] != ' password')
									@if (array_key_exists('callback_view', $field))
										{!! call_user_func($field['callback_view'], $field, $crud->item) !!}
									@elseif ($field['type'] == 'select')
										{{ $field['values'][$field['value']] }}
									@elseif(!$field['value'] || in_array($field['value'], ['0000-00-00', '0000-00-00 00:00:00']))
										-
									@elseif ($field['type'] == 'multiselect')
										<ul>
											@foreach ($field['value'] as $value)
												<li>{{ $field['values'][$value] }}</li>
											@endforeach
										</ul>
									@elseif ($field['type'] == 'active')
										{{ trans("crud::crud.general.active.{$field['value']}") }}
									@elseif (in_array($field['type'], ['date', 'datepicker']))
										{{ \Carbon\Carbon::parse($field['value'])->format('Y-m-d') }}
									@elseif ($field['type'] == 'datetime')
										{{ \Carbon\Carbon::parse($field['value'])->format('Y-m-d H:i:s') }}
									@else
										{!! @$field['value'] !!}
									@endif
								@endif
							</div>
						</div>
					@endforeach
		    	</div><!-- /.box-body -->
		    	<div class="box-footer">
					@if (array_key_exists('edit', $crud->buttons()) && $button = $crud->buttons()['edit'])
						<a href="{{ str_replace('%d', $crud->item->id, $button['route']) }}" class="btn btn-primary ladda-button" data-style="zoom-in">
							<span class="ladda-label">
								@if (array_key_exists('icon', $button))
			                        <i class="fa {{ $button['icon'] }}"></i>
			                    @endif

			                    {{ $button['label'] }}
							</span>
						</a>
					@endif
		    	</div><!-- /.box-footer-->
		  	</div><!-- /.box -->
		</div>
	</div>
@stop
