<?php
namespace App\Http\Controllers\Admin;

// VALIDATION: change the requests to match your own file names if you need form validation
use Validator;
use App\Http\Requests\ProgramRequest as StoreRequest;
use App\Http\Requests\ProgramRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class ProgramCrudController extends CrudController
{

    public function __construct()
    {
        parent::__construct();

        /**
         * |--------------------------------------------------------------------------
         * | BASIC CRUD INFORMATION
         * |--------------------------------------------------------------------------
         */
        $this->crud->setModel("App\Models\Program");
        $this->crud->setRoute('admin/program');
        $this->crud->setEntityNameStrings('program', 'programs');

        /**
         * |--------------------------------------------------------------------------
         * | BASIC CRUD INFORMATION
         * |--------------------------------------------------------------------------
         */
        $this->crud->addField([
            'name'    => '0',
            'label'   => 'Основная информация',
            'type'    => 'separator',
            'colspan' => 10,
        ]);
        $this->crud->addField([ // TEXT
            'name'        => 'title',
            'label'       => 'Заголовок',
            'type'        => 'text',
            'placeholder' => 'Название программы',
            'colspan'     => '10',
        ]);
        $this->crud->addField([ // CHECKBOX
            'name'    => 'published',
            'label'   => 'Опубликованно',
            'type'    => 'checkbox',
            'colspan' => 2,
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'slogan',
            'label' => 'Слоган',
            'type'  => 'text',
        ]);
        $this->crud->addField([
            'label'    => 'Картинка',
            'name'     => 'images',
            'type'     => 'repeater_image',
            'cssclass' => 'main-image',
            'colspan'  => '5',
        ]);
        $this->crud->addField([ // Image
            'name'    => 'videos',
            'label'   => 'Видео',
            'type'    => 'repeater_video',
            'colspan' => '5',
        ]);
        $this->crud->addField([ // WYSIWYG
            'name'        => 'description',
            'label'       => 'Описание',
            'type'        => 'ckeditor',
            'placeholder' => 'Введите описание',
            'colspan'     => '12',
        ]);
        $this->crud->addField([ // WYSIWYG
            'name'    => 'press_materials',
            'label'   => 'Пресс-материалы',
            'type'    => 'ckeditor',
            'colspan' => '12',
        ]);
        // $this->crud->addField([ // Select2Multiple = n-n relationship (with pivot table)
        //     'label'     => 'Сеансы',
        //     'type'      => 'select2_multiple',
        //     'name'      => 'seances', // the method that defines the relationship in your Model
        //     'entity'    => 'seances', // the method that defines the relationship in your Model
        //     'attribute' => 'start_time', // foreign key attribute that is shown to user
        //     'model'     => 'App\Models\Seance', // foreign key model
        //     // 'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
        // ]);
        $this->crud->addField([
            'name'  => '2',
            'label' => 'SEO данные',
            'type'  => 'separator',
        ]);
        $this->crud->addField([ // TEXT
            'name'     => 'meta_title',
            'label'    => 'Meta-Title',
            'hint'     => 'Если не заполнять, примет значение название события',
            'fake'     => true,
            'colspan'  => '6',
            'store_in' => 'meta',
        ]);
        $this->crud->addField([
            'name'    => 'slug',
            'label'   => 'ЧПУ (URL)',
            'type'    => 'text',
            'colspan' => '6',
            'hint'    => 'Если не заполнять, создастся автоматически',
            // 'disabled' => 'disabled'
        ]);

        $this->crud->addField([ // TEXT
            'name'     => 'meta_description',
            'label'    => 'Meta-Description',
            'hint'     => 'Если не заполнять, примет значение перых 30 слов из описания события',
            'fake'     => true,
            'store_in' => 'meta',
        ]);
        $this->crud->addField([ // TEXT
            'name'     => 'meta_keywords',
            'label'    => 'Meta-Keywords',
            'fake'     => true,
            'store_in' => 'meta',
        ]);

        /**
         *  ------ CRUD COLUMNS
         */
        $this->crud->addColumn([
            'name'  => 'title',
            'label' => 'Название',
        ]);
        $this->crud->addColumn([
            'name'  => 'published',
            'label' => 'Опубликованно',
        ]);
        $this->crud->addColumn([
            'name'  => 'start_date',
            'label' => 'Начало',
            'type'  => 'date',
        ]);
        $this->crud->addColumn([
            'name'  => 'end_date',
            'label' => 'Конец',
            'type'  => 'date',
        ]);

        // ------ CRUD DETAILS ROW
        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');
        // NOTE: you also need to do allow access to the right users:
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'max:255'],
            'slug'  => ['required', 'unique:programs', 'max:255'],
        ], [
            'title.required' => 'Необходимо указать заголовок',
            'slug.required'  => 'Необходимо указать псевдоним',
        ]);

        if ($validator->fails())
        {
            return redirect('/admin/event/create')
            ->withErrors($validator)
            ->withInput();
        }

        return parent::storeCrud();
    }

    public function update(UpdateRequest $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'max:255'],
            'slug'  => ['required', 'max:255'],
        ], [
            'title.required' => 'Необходимо указать заголовок',
            'slug.required'  => 'Необходимо указать псевдоним',
        ]);

        if ($validator->fails())
        {
            return redirect('/admin/event/'.$id.'/edit')
            ->withErrors($validator)
            ->withInput();
        }

        return parent::updateCrud();
    }
}
