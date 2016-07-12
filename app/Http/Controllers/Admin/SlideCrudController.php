<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\SlideRequest as StoreRequest;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SlideRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class SlideCrudController extends CrudController
{

    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
         */
        $this->crud->setModel("App\Models\Slide");
        $this->crud->setRoute('admin/slide');
        $this->crud->setEntityNameStrings('slide', 'slides');

        // ------ CRUD COLUMNS
        $cols = [[
            'name'  => 'title',
            'label' => 'Название',
            'type'  => 'text',
        ], [
            'label'     => 'Категория',
            'type'      => 'select',
            'name'      => 'category_id',
            'entity'    => 'category',
            'attribute' => 'name',
            'model'     => "App\Models\Category",
        ], [
            'name'  => 'src',
            'label' => 'Изображение',
            'type'  => 'text',
        ]];
        $this->crud->addColumns($cols); // add multiple columns, at the end of the stack

        // ------ CRUD FIELDS
        $fields = [[
            'name'  => 'published',
            'label' => 'Показывать',
            'type'  => 'checkbox',
        ], [
            'name'  => 'title',
            'label' => 'Название',
            'type'  => 'text',
        ], [
            'name'  => 'src',
            'label' => 'Изображение',
            'type'  => 'browse',
        ], [
            'name'     => 'caption_title',
            'label'    => 'Заголовок',
            'fake'     => true,
            'store_in' => 'caption',
        ], [
            'name'     => 'link',
            'label'    => 'Сылка на событие или программу',            
            'type'     => 'text',
        ], [
            'name'     => 'caption_content',
            'label'    => 'Содержимое',
            'fake'     => true,
            'store_in' => 'caption',
        ], [ // select
            'name'        => 'category_id',
            'label'       => 'Категория',
            'type'        => 'select',
            'allows_null' => false,
            'entity'      => 'category',
            'colspan'     => '2',
            'attribute'   => 'name',
            'model'       => "App\Models\Category",
        ]];

        $this->crud->addFields($fields);

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']);
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}
