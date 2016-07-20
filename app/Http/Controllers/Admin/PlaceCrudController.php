<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PlaceRequest as StoreRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PlaceRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class PlaceCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
         */
        $this->crud->setModel("App\Models\Place");
        $this->crud->setRoute('admin/place');
        $this->crud->setEntityNameStrings('place', 'places');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
         */

        // ------ CRUD COLUMNS
        $this->crud->addColumns([
            ['name' => 'title', 'type' => 'text', 'label' => 'Название'],
            ['name' => 'address', 'type' => 'textarea', 'label' => 'Адрес'],
            ['name' => 'metro', 'type' => 'text', 'label' => 'Метро'],
            // ['name' => 'lat', 'type' => 'number', 'label' => 'Широта'],
            // ['name' => 'lng', 'type' => 'number', 'label' => 'Долгота'],
        ]);

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name'    => 'published',
            'type'    => 'checkbox',
            'label'   => 'Опубликовано',
            'colspan' => 4,
        ]);
        $this->crud->addField([
            'name'    => 'title',
            'type'    => 'text',
            'label'   => 'Название',
            'colspan' => 4,
        ]);
        $this->crud->addField([
            'name'    => 'metro',
            'type'    => 'text',
            'label'   => 'Метро',
            'colspan' => 4,
        ]);
        $this->crud->addField([
            'name'     => 'place_type',
            'type'     => 'text',
            'label'    => 'Тип места',
            'fake'     => true,
            'store_in' => 'properties',
            'colspan'  => 4,
        ]);
        $this->crud->addField([
            'name'    => 'description',
            'type'    => 'summernote',
            'label'   => 'Описание',
            'colspan' => 6,
        ]);
        $this->crud->addField([
            'name'    => 'address',
            'type'    => 'textarea',
            'label'   => 'Адрес',
            'colspan' => 6,
        ]);
        $this->crud->addField([
            'name'     => 'place_site',
            'type'     => 'text',
            'label'    => 'Сайт',
            'colspan'  => 4,
        ]);
        $this->crud->addField([
            'name'     => 'place_email',
            'type'     => 'email',
            'label'    => 'E-mail',
            'colspan'  => 4,
        ]);
        $this->crud->addField([
            'name'     => 'place_phone',
            'type'     => 'text',
            'label'    => 'Телефон',
            'colspan'  => 4,
        ]);
        // $this->crud->addField([
        //     'name'     => 'lat',
        //     'type'     => 'text',
        //     'step'     => 0.00000001,
        //     'label'    => 'Широта',
        //     // 'fake'     => true,
        //     // 'store_in' => 'position',
        //     'colspan'  => 4,
        // ]);
        $this->crud->addField([
            'name'     => 'position',
            'type'     => 'text',
            'label'    => 'Координаты',
            'colspan'  => 4,
        ]);

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
        // $this->crud->allowAccess('details_row');
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
        // dd($request);
        return parent::updateCrud();
    }
}
