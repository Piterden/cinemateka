<?php $__env->startSection('after_styles'); ?>
	<!-- DATA TABLES -->
    <link href="<?php echo e(asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize"><?php echo e($crud->entity_name_plural); ?></span>
	    <small><?php echo e(trans('backpack::crud.all')); ?> <span class="text-lowercase"><?php echo e($crud->entity_name_plural); ?></span> <?php echo e(trans('backpack::crud.in_the_database')); ?>.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="<?php echo e(url('admin/dashboard')); ?>">Admin</a></li>
	    <li><a href="<?php echo e(url($crud->route)); ?>" class="text-capitalize"><?php echo e($crud->entity_name_plural); ?></a></li>
	    <li class="active"><?php echo e(trans('backpack::crud.list')); ?></li>
	  </ol>
	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <?php if($crud->hasAccess('create')): ?>
      		<a href="<?php echo e(url($crud->route.'/create')); ?>" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> <?php echo e(trans('backpack::crud.add')); ?> <?php echo e($crud->entity_name); ?></span></a>
      <?php endif; ?>
      <?php if($crud->reorder): ?>
        <?php if($crud->hasAccess('reorder')): ?>
          <a href="<?php echo e(url($crud->route.'/reorder')); ?>" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-arrows"></i> <?php echo e(trans('backpack::crud.reorder')); ?> <?php echo e($crud->entity_name_plural); ?></span></a>
          <?php endif; ?>
      <?php endif; ?>
    </div>
  <div class="box-body">

		<table id="crudTable" class="table table-bordered table-striped display">
      <thead>
        <tr>
          <?php if($crud->details_row): ?>
            <th></th> <!-- expand/minimize button column -->
          <?php endif; ?>

          <?php /* Table columns */ ?>
          <?php foreach($crud->columns as $column): ?>
            <th><?php echo e($column['label']); ?></th>
          <?php endforeach; ?>

          <?php if( !( isset($crud->edit_permission) && $crud->edit_permission === false && isset($crud->delete_permission) && $crud->delete_permission === false ) ): ?>
            <th><?php echo e(trans('backpack::crud.actions')); ?></th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>

        <?php foreach($entries as $k => $entry): ?>
        <tr data-entry-id="<?php echo e($entry->id); ?>">

          <?php if($crud->details_row): ?>
            <!-- expand/minimize button column -->
            <td class="details-control text-center cursor-pointer">
              <i class="fa fa-plus-square-o"></i>
            </td>
          <?php endif; ?>

          <?php foreach($crud->columns as $column): ?>
            <?php if(isset($column['type']) && $column['type']=='select_multiple'): ?>
              <?php /* relationships with pivot table (n-n) */ ?>
              <td><?php
                $results = $entry->{$column['entity']}()->getResults();
                if ($results && $results->count()) {
                  $results_array = $results->lists($column['attribute'], 'id');
                  echo implode(', ', $results_array->toArray());
                } else {
                  echo '-';
                }
              ?></td>
            <?php elseif(isset($column['type']) && $column['type']=='select'): ?>
              <?php /* single relationships (1-1, 1-n) */ ?>
              <td><?php
                if ($entry->{$column['entity']}()->getResults()) {
                  echo $entry->{$column['entity']}()->getResults()->{$column['attribute']};
                }
              ?></td>
            <?php elseif(isset($column['type']) && $column['type']=='model_function'): ?>
              <?php /* custom return value */ ?>
              <td><?php
                echo $entry->{$column['function_name']}();
              ?></td>
            <?php else: ?>
              <?php /* regular object attribute */ ?>
              <td><?php echo e(str_limit(strip_tags($entry->{$column['name']}), 80, "[...]")); ?></td>
            <?php endif; ?>

          <?php endforeach; ?>

          <?php if( !( isset($crud->edit_permission) && $crud->edit_permission === false && isset($crud->delete_permission) && $crud->delete_permission === false ) ): ?>
            <td>
              <a href="<?php echo e('/'.Request::segment(2).'/'.$entry->slug); ?>"
                class="btn btn-xs btn-default"
                target="_blank"
              ><i class="fa fa-eye"></i> <?php echo e(trans('backpack::crud.preview')); ?>

              </a>
              <?php if($crud->hasAccess('update')): ?>
                <a href="<?php echo e(Request::url().'/'.$entry->id); ?>/edit"
                  class="btn btn-xs btn-default"
                ><i class="fa fa-edit"></i> <?php echo e(trans('backpack::crud.edit')); ?>

                </a>
              <?php endif; ?>
              <?php if($crud->hasAccess('delete')): ?>
                <a href="<?php echo e(Request::url().'/'.$entry->id); ?>"
                  class="btn btn-xs btn-default"
                  data-button-type="delete"
                ><i class="fa fa-trash"></i> <?php echo e(trans('backpack::crud.delete')); ?>

                </a>
              <?php endif; ?>
            </td>
          <?php endif; ?>
        </tr>
        <?php endforeach; ?>

      </tbody>
      <tfoot>
        <tr>
          <?php if($crud->details_row): ?>
            <th></th> <!-- expand/minimize button column -->
          <?php endif; ?>

          <?php /* Table columns */ ?>
          <?php foreach($crud->columns as $column): ?>
            <th><?php echo e($column['label']); ?></th>
          <?php endforeach; ?>

          <?php if( !( isset($crud->edit_permission) && $crud->edit_permission === false && isset($crud->delete_permission) && $crud->delete_permission === false ) ): ?>
            <th><?php echo e(trans('backpack::crud.actions')); ?></th>
          <?php endif; ?>
        </tr>
      </tfoot>
    </table>

    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<!-- DATA TABES SCRIPT -->
    <script src="<?php echo e(asset('vendor/adminlte/plugins/datatables/jquery.dataTables.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.js')); ?>" type="text/javascript"></script>

	<script type="text/javascript">
	  jQuery(document).ready(function($) {
	  	var table = $("#crudTable").DataTable({
        "language": {
              "emptyTable":     "<?php echo e(trans('backpack::crud.emptyTable')); ?>",
              "info":           "<?php echo e(trans('backpack::crud.info')); ?>",
              "infoEmpty":      "<?php echo e(trans('backpack::crud.infoEmpty')); ?>",
              "infoFiltered":   "<?php echo e(trans('backpack::crud.infoFiltered')); ?>",
              "infoPostFix":    "<?php echo e(trans('backpack::crud.infoPostFix')); ?>",
              "thousands":      "<?php echo e(trans('backpack::crud.thousands')); ?>",
              "lengthMenu":     "<?php echo e(trans('backpack::crud.lengthMenu')); ?>",
              "loadingRecords": "<?php echo e(trans('backpack::crud.loadingRecords')); ?>",
              "processing":     "<?php echo e(trans('backpack::crud.processing')); ?>",
              "search":         "<?php echo e(trans('backpack::crud.search')); ?>",
              "zeroRecords":    "<?php echo e(trans('backpack::crud.zeroRecords')); ?>",
              "paginate": {
                  "first":      "<?php echo e(trans('backpack::crud.paginate.first')); ?>",
                  "last":       "<?php echo e(trans('backpack::crud.paginate.last')); ?>",
                  "next":       "<?php echo e(trans('backpack::crud.paginate.next')); ?>",
                  "previous":   "<?php echo e(trans('backpack::crud.paginate.previous')); ?>"
              },
              "aria": {
                  "sortAscending":  "<?php echo e(trans('backpack::crud.aria.sortAscending')); ?>",
                  "sortDescending": "<?php echo e(trans('backpack::crud.aria.sortDescending')); ?>"
              }
          }
      });

      <?php if($crud->details_row): ?>
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
                url: '<?php echo e(Request::url()); ?>/'+tr.data('entry-id')+'/details',
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
      <?php endif; ?>

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

          if (confirm("<?php echo e(trans('backpack::crud.delete_confirm')); ?>") == true) {
              $.ajax({
                  url: delete_url,
                  type: 'DELETE',
                  success: function(result) {
                      // Show an alert with the result
                      new PNotify({
                          title: "<?php echo e(trans('backpack::crud.delete_confirmation_title')); ?>",
                          text: "<?php echo e(trans('backpack::crud.delete_confirmation_message')); ?>",
                          type: "success"
                      });
                      // delete the row from the table
                      delete_button.parentsUntil('tr').parent().remove();
                  },
                  error: function(result) {
                      // Show an alert with the result
                      new PNotify({
                          title: "<?php echo e(trans('backpack::crud.delete_confirmation_not_title')); ?>",
                          text: "<?php echo e(trans('backpack::crud.delete_confirmation_not_message')); ?>",
                          type: "warning"
                      });
                  }
              });
          } else {
              new PNotify({
                  title: "<?php echo e(trans('backpack::crud.delete_confirmation_not_deleted_title')); ?>",
                  text: "<?php echo e(trans('backpack::crud.delete_confirmation_not_deleted_message')); ?>",
                  type: "info"
              });
          }
        });
      }


	  });
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backpack::layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>