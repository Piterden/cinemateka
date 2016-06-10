<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dick Crud Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the CRUD interface.
    | You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    // Create form
    'add'                 => 'Add',
    'back_to_all'         => 'Back to all ',
    'cancel'              => 'Cancel',
    'add_a_new'           => 'Add a new ',

        // Create form - advanced options
        'after_saving'            => 'After saving',
        'go_to_the_table_view'    => 'go to the table view',
        'let_me_add_another_item' => 'let me add another item',
        'edit_the_new_item'       => 'edit the new item',

    // Edit form
    'edit'                 => 'Edit',
    'save'                 => 'Save',

    // CRUD table view
    'all'                  => 'All ',
    'in_the_database'      => 'in the database',
    'list'                 => 'List',
    'actions'              => 'Actions',
    'preview'              => 'Preview',
    'delete'               => 'Delete',

        // Confirmation messages and bubbles
        'delete_confirm'                              => 'Are you sure you want to delete this item?',
        'delete_confirmation_title'                   => 'Item Deleted',
        'delete_confirmation_message'                 => 'The item has been deleted successfully.',
        'delete_confirmation_not_title'               => 'NOT deleted',
        'delete_confirmation_not_message'             => "There's been an error. Your item might not have been deleted.",
        'delete_confirmation_not_deleted_title'       => 'Not deleted',
        'delete_confirmation_not_deleted_message'     => 'Nothing happened. Your item is safe.',

        // DataTables translation
        'emptyTable'     => 'No data available in table',
        'info'           => 'Showing _START_ to _END_ of _TOTAL_ entries',
        'infoEmpty'      => 'Showing 0 to 0 of 0 entries',
        'infoFiltered'   => '(filtered from _MAX_ total entries)',
        'infoPostFix'    => '',
        'thousands'      => ',',
        'lengthMenu'     => '_MENU_ records per page',
        'loadingRecords' => 'Loading...',
        'processing'     => 'Processing...',
        'search'         => 'Search: ',
        'zeroRecords'    => 'No matching records found',
        'paginate'       => [
            'first'    => 'First',
            'last'     => 'Last',
            'next'     => 'Next',
            'previous' => 'Previous',
        ],
        'aria' => [
            'sortAscending'  => ': activate to sort column ascending',
            'sortDescending' => ': activate to sort column descending',
        ],

    // global crud - errors
    'unauthorized_access' => 'Unauthorized access - you do not have the necessary permissions to see this page.',

    // global crud - success / error notification bubbles
    'insert_success' => 'The item has been added successfully.',
    'update_success' => 'The item has been modified successfully.',

    // CRUD reorder view
    'reorder'                      => 'Reorder',
    'reorder_text'                 => 'Use drag&drop to reorder.',
    'reorder_success_title'        => 'Done',
    'reorder_success_message'      => 'Your order has been saved.',
    'reorder_error_title'          => 'Error',
    'reorder_error_message'        => 'Your order has not been saved.',

    'rules_text'    => "<strong>Notice: </strong> Do not translate words prefixed with colon (ex: ':number_of_items'). Those will be replaced automatically with a proper value. If translated, that stops working.",

];
