@extends('backpack::layout')

@section('after_styles')
	<!-- DATA TABLES -->
    <link href="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
	    <small>{{ trans('backpack::crud.all') }} <span class="text-lowercase">{{ $crud->entity_name_plural }}</span> {{ trans('backpack::crud.in_the_database') }}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url('admin/dashboard') }}">Admin</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.list') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      @if ($crud->hasAccess('create'))
      		<a href="{{ url($crud->route.'/create') }}" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> {{ trans('backpack::crud.add') }} {{ $crud->entity_name }}</span></a>
      @endif
      @if ($crud->reorder)
        @if ($crud->hasAccess('reorder'))
          <a href="{{ url($crud->route.'/reorder') }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-arrows"></i> {{ trans('backpack::crud.reorder') }} {{ $crud->entity_name_plural }}</span></a>
          @endif
      @endif
    </div>
  <div class="box-body">

		<table id="crudTable" class="table table-bordered table-striped display">
      <thead>
        <tr>
          @if ($crud->details_row)
            <th></th> <!-- expand/minimize button column -->
          @endif

          {{-- Table columns --}}
          @foreach ($crud->columns as $column)
            <th>{{ $column['label'] }}</th>
          @endforeach

          @if ( !( isset($crud->edit_permission) && $crud->edit_permission === false && isset($crud->delete_permission) && $crud->delete_permission === false ) )
            <th>{{ trans('backpack::crud.actions') }}</th>
          @endif
        </tr>
      </thead>
      <tbody>

        @foreach ($entries as $k => $entry)
        <tr data-entry-id="{{ $entry->id }}">

          @if ($crud->details_row)
            <!-- expand/minimize button column -->
            <td class="details-control text-center cursor-pointer">
              <i class="fa fa-plus-square-o"></i>
            </td>
          @endif

          @foreach ($crud->columns as $column)
            @if (isset($column['type']) && $column['type']=='select_multiple')
              {{-- relationships with pivot table (n-n) --}}
              <td><?php
                $results = $entry->{$column['entity']}()->getResults();
                if ($results && $results->count()) {
                  $results_array = $results->lists($column['attribute'], 'id');
                  echo implode(', ', $results_array->toArray());
                } else {
                  echo '-';
                }
              ?></td>
            @elseif (isset($column['type']) && $column['type']=='select')
              {{-- single relationships (1-1, 1-n) --}}
              <td><?php
                if ($entry->{$column['entity']}()->getResults()) {
                  echo $entry->{$column['entity']}()->getResults()->{$column['attribute']};
                }
              ?></td>
            @elseif (isset($column['type']) && $column['type']=='model_function')
              {{-- custom return value --}}
              <td><?php
                echo $entry->{$column['function_name']}();
              ?></td>
            @else
              {{-- regular object attribute --}}
              <td>{{ str_limit(strip_tags($entry->{$column['name']}), 80, "[...]") }}</td>
            @endif

          @endforeach

          @if ( !( isset($crud->edit_permission) && $crud->edit_permission === false && isset($crud->delete_permission) && $crud->delete_permission === false ) )
            <td>
              <a href="{{ '/'.Request::segment(2).'/'.$entry->slug }}"
                class="btn btn-xs btn-default"
                target="_blank"
              ><i class="fa fa-eye"></i> {{ trans('backpack::crud.preview') }}
              </a>
              @if ($crud->hasAccess('update'))
                <a href="{{ Request::url().'/'.$entry->id }}/edit"
                  class="btn btn-xs btn-default"
                ><i class="fa fa-edit"></i> {{ trans('backpack::crud.edit') }}
                </a>
              @endif
              @if ($crud->hasAccess('delete'))
                <a href="{{ Request::url().'/'.$entry->id }}"
                  class="btn btn-xs btn-default"
                  data-button-type="delete"
                ><i class="fa fa-trash"></i> {{ trans('backpack::crud.delete') }}
                </a>
              @endif
            </td>
          @endif
        </tr>
        @endforeach

      </tbody>
      <tfoot>
        <tr>
          @if ($crud->details_row)
            <th></th> <!-- expand/minimize button column -->
          @endif

          {{-- Table columns --}}
          @foreach ($crud->columns as $column)
            <th>{{ $column['label'] }}</th>
          @endforeach

          @if ( !( isset($crud->edit_permission) && $crud->edit_permission === false && isset($crud->delete_permission) && $crud->delete_permission === false ) )
            <th>{{ trans('backpack::crud.actions') }}</th>
          @endif
        </tr>
      </tfoot>
    </table>

    </div>
  </div>
@endsection

@section('after_scripts')
	<!-- DATA TABES SCRIPT -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
	  jQuery(document).ready(function($) {
	  	var table = $("#crudTable").DataTable({
        "language": {
              "emptyTable":     "{{ trans('backpack::crud.emptyTable') }}",
              "info":           "{{ trans('backpack::crud.info') }}",
              "infoEmpty":      "{{ trans('backpack::crud.infoEmpty') }}",
              "infoFiltered":   "{{ trans('backpack::crud.infoFiltered') }}",
              "infoPostFix":    "{{ trans('backpack::crud.infoPostFix') }}",
              "thousands":      "{{ trans('backpack::crud.thousands') }}",
              "lengthMenu":     "{{ trans('backpack::crud.lengthMenu') }}",
              "loadingRecords": "{{ trans('backpack::crud.loadingRecords') }}",
              "processing":     "{{ trans('backpack::crud.processing') }}",
              "search":         "{{ trans('backpack::crud.search') }}",
              "zeroRecords":    "{{ trans('backpack::crud.zeroRecords') }}",
              "paginate": {
                  "first":      "{{ trans('backpack::crud.paginate.first') }}",
                  "last":       "{{ trans('backpack::crud.paginate.last') }}",
                  "next":       "{{ trans('backpack::crud.paginate.next') }}",
                  "previous":   "{{ trans('backpack::crud.paginate.previous') }}"
              },
              "aria": {
                  "sortAscending":  "{{ trans('backpack::crud.aria.sortAscending') }}",
                  "sortDescending": "{{ trans('backpack::crud.aria.sortDescending') }}"
              }
          }
      });

      @if ($crud->details_row)
      // Add event listener for opening and closing details
      $('#crudTable tbody').on('click', 'td.details-control', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr );

          if ( row.child.isShown() ) {
              // This row is already open - close it
              $(this).children('i').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
              $('div.table_row_slider', row.child()).slideUp( function () {
                  row.child.hide();
                  tr.removeClass('shown');
              } );
          }
          else {
              // Open this row
              $(this).children('i').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
              // Get the details with ajax
              $.ajax({
                url: '{{ Request::url() }}/'+tr.data('entry-id')+'/details',
                type: 'GET',
                // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
                // data: {param1: 'value1'},
              })
              .done(function(data) {
                // console.log("-- success getting table extra details row with AJAX");
                row.child("<div class='table_row_slider'>" + data + "</div>", 'no-padding').show();
                tr.addClass('shown');
                $('div.table_row_slider', row.child()).slideDown();
                register_delete_button_action();
              })
              .fail(function(data) {
                // console.log("-- error getting table extra details row with AJAX");
                row.child("<div class='table_row_slider'>There was an error loading the details. Please retry. </div>").show();
                tr.addClass('shown');
                $('div.table_row_slider', row.child()).slideDown();
              })
              .always(function(data) {
                // console.log("-- complete getting table extra details row with AJAX");
              });
          }
      } );
      @endif

      $.ajaxPrefilter(function(options, originalOptions, xhr) {
          var token = $('meta[name="csrf_token"]').attr('content');

          if (token) {
                return xhr.setRequestHeader('X-XSRF-TOKEN', token);
          }
    });

      // make the delete button work in the first result page
      register_delete_button_action();

      // make the delete button work on subsequent result pages
      $('#crudTable').on( 'draw.dt',   function () {
         register_delete_button_action();
      } ).dataTable();

      function register_delete_button_action() {
        $("[data-button-type=delete]").unbind('click');
        // CRUD Delete
        // ask for confirmation before deleting an item
        $("[data-button-type=delete]").click(function(e) {
          e.preventDefault();
          var delete_button = $(this);
          var delete_url = $(this).attr('href');

          if (confirm("{{ trans('backpack::crud.delete_confirm') }}") == true) {
              $.ajax({
                  url: delete_url,
                  type: 'DELETE',
                  success: function(result) {
                      // Show an alert with the result
                      new PNotify({
                          title: "{{ trans('backpack::crud.delete_confirmation_title') }}",
                          text: "{{ trans('backpack::crud.delete_confirmation_message') }}",
                          type: "success"
                      });
                      // delete the row from the table
                      delete_button.parentsUntil('tr').parent().remove();
                  },
                  error: function(result) {
                      // Show an alert with the result
                      new PNotify({
                          title: "{{ trans('backpack::crud.delete_confirmation_not_title') }}",
                          text: "{{ trans('backpack::crud.delete_confirmation_not_message') }}",
                          type: "warning"
                      });
                  }
              });
          } else {
              new PNotify({
                  title: "{{ trans('backpack::crud.delete_confirmation_not_deleted_title') }}",
                  text: "{{ trans('backpack::crud.delete_confirmation_not_deleted_message') }}",
                  type: "info"
              });
          }
        });
      }


	  });
	</script>
@endsection
