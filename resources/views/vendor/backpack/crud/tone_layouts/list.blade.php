@extends('crud::crud')

@section('after_styles')
    @parent

    <!-- DATA TABLES -->
    <link href="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    @include('crud::layouts.head')

    <div class="box box-primary">
        <div class="box-header with-border">
            @foreach($crud->customButtons() as $button)
                <a href="{{ route($button['route']) }}" class="btn btn-default">
                    @if (array_key_exists('icon', $button))
                        <i class="fa {{ $button['icon'] }}"></i>
                    @endif
                    {{ $button['label'] }}
                </a>
            @endforeach
            @if (array_key_exists('add', $crud->buttons()))
            	<a href="{{ $crud->buttons()['add']['route'] }}" class="btn btn-primary ladda-button" data-style="zoom-in">
                    <span class="ladda-label">
                         @if (array_key_exists('icon', $crud->buttons()['add']))
                            <i class="fa {{ $crud->buttons()['add']['icon'] }}"></i>
                        @endif
                        {{ $crud->buttons()['add']['label'] }} {{-- $crud['entity_name'] --}}
                    </span>
                </a>
            @endif
            @include('crud::layouts.tabs')
        </div>

        <div class="box-body">
    		<table id="crud-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        @foreach ($crud->columns() as $column)
                            <th>{!! $column['label'] or $crud->labels()[$column['name']] !!}</th>
                        @endforeach

                        @if ($crud->showButtons())
                            <th class="text-center" data-sortable="false">@lang('crud::crud.list.actions')</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @foreach ($crud->items() as $item)
                    <tr data-item-id="{{ $item->id }}">
                        @foreach ($crud->columns() as $column)
                            <td>
                                @if (array_key_exists('callback', $column) && $column['callback'])
                                    {!! call_user_func($column['callback'], $item) !!}
                                @elseif (array_key_exists($column['name'], $crud->getRelations()))
                                    @include('crud::layouts.relations')
                                @else
                                    @include('crud::layouts.column')
                                @endif
                            </td>
                        @endforeach

                        @include('crud::layouts.actions')
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>

                    </tr>
                </tfoot>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
@stop

@section('after_scripts')
    @parent

    <!-- DATATABLES SCRIPT -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>



    <script>
        jQuery(document).ready(function($) {
            var table = $("#crud-table").DataTable({
                "language": {
                    "emptyTable":     "{{ trans('crud::crud.datatable.empty_table') }}",
                    "info":           "{{ trans('crud::crud.datatable.info') }}",
                    "infoEmpty":      "{{ trans('crud::crud.datatable.info_empty') }}",
                    "infoFiltered":   "{{ trans('crud::crud.datatable.info_filtered') }}",
                    "infoPostFix":    "{{ trans('crud::crud.datatable.info_post_fix') }}",
                    "thousands":      "{{ trans('crud::crud.datatable.thousands') }}",
                    "lengthMenu":     "{{ trans('crud::crud.datatable.length_menu') }}",
                    "loadingRecords": "{{ trans('crud::crud.datatable.loading_records') }}",
                    "processing":     "{{ trans('crud::crud.datatable.processing') }}",
                    "search":         "{{ trans('crud::crud.datatable.search') }}",
                    "zeroRecords":    "{{ trans('crud::crud.datatable.zero_records') }}",
                    "paginate": {
                        "first":      "{{ trans('crud::crud.datatable.paginate.first') }}",
                        "last":       "{{ trans('crud::crud.datatable.paginate.last') }}",
                        "next":       "{{ trans('crud::crud.datatable.paginate.next') }}",
                        "previous":   "{{ trans('crud::crud.datatable.paginate.previous') }}"
                    },
                    "aria": {
                        "sortAscending":  "{{ trans('crud::crud.datatable.aria.sort_ascending') }}",
                        "sortDescending": "{{ trans('crud::crud.datatable.aria.sort_descending') }}"
                    },
                }
            });

            $('#crud-table tbody').on('click', '[data-type=delete]', function(event) {
                event.preventDefault();

                var deleteBtn = $(this);

                if (confirm(deleteBtn.data('confirm'))) {
                    $.ajax({
                        url: deleteBtn.attr('href'),
                        type: 'DELETE',
                        dataType: 'json',
                        data: {},
                        success: function(response) {
                            table.row(deleteBtn.parentsUntil('tr').parent()).remove().draw();
                            $.notify({
                                icon: 'fa fa-check-circle-o',
                                title: '{!! trans("crud::crud.alerts.title.success") !!}',
                                message: '{!! trans("crud::crud.form.delete_success") !!}'
                            },{
                                type: "success"
                            });
                        }/*,
                        error: function(response) {
                            alert('Error');
                        }*/
                    });
                }
            });
        });
    </script>
@stop
