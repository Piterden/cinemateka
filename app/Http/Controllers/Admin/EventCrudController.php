<?php

namespace App\Http\Controllers\Admin;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\EventRequest as StoreRequest;
use App\Http\Requests\EventRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class EventCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
         */
        $this->crud->setModel("App\Models\Event");
        $this->crud->setRoute('admin/event');
        $this->crud->setEntityNameStrings('event', 'events');

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
         */

        /*
         *  ------ CRUD COLUMNS
         */
        $this->crud->addColumn([
            'name' => 'title',
            'label' => 'Название',
        ]);
        $this->crud->addColumn([
            'name' => 'published',
            'label' => 'Статус',
        ]);
        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => 'Добавлено',
            'type' => 'date',
        ]);
        $this->crud->addColumn([
            'name' => 'category_id',
            'label' => 'Тип события',
            'type' => 'select',
            'allows_null' => false,
            'entity'    => 'category',
            'colspan' => '2',
            'attribute' => 'name',
            'model'     => "App\Models\Category",
        ]);

        /*
         *  ------ CRUD FIELDS
         */
        $this->crud->addField([
            'name' => 'service_1',
            'value' => '<div class="col-md-6"><h3>Дополнительная информация</h3></div>',
            'type' => 'custom_html',
        ]);
        $this->crud->addField([ // Image
            'name' => 'images',
            'label' => 'Картинка',
            'type' => 'image_upload_multiple',
            'colspan' => '6',
            'cssclass' => 'multi-upload'
        ]);
        $this->crud->addField([ // CHECKBOX
            'name' => 'published',
            'label' => 'Опубликованно',
            'type' => 'checkbox',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'title',
            'label' => 'Заголовок',
            'type' => 'text',
            'placeholder' => 'Название события',
            'v-model' => 'title',
        ]);
        $this->crud->addField([
            'name' => 'slug',
            'label' => 'ЧПУ (URL)',
            'type' => 'text',
            'hint' => 'Если не заполнять, создастся автоматически',
            'v-model' => 'slug'
        ]);
        $this->crud->addField([ // select
            'name' => 'category_id',
            'label' => 'Тип события',
            'type' => 'select',
            'allows_null' => false,
            'entity'    => 'category',
            'colspan' => '2',
            'attribute' => 'name',
            'model'     => "App\Models\Category",
        ]);
        $this->crud->addField([ // Image
            'name' => 'videos',
            'label' => 'Видео',
            'type' => 'text',
            'colspan' => '5',
        ]);
        $this->crud->addField([ // WYSIWYG
            'name' => 'description',
            'label' => 'Описание',
            'type' => 'ckeditor',
            'placeholder' => 'Your textarea text here',
        ]);
        $this->crud->addField([ // Select2Multiple = n-n relationship (with pivot table)
            'label' => 'Сеансы',
            'type' => 'select2_multiple',
            'name' => 'seances', // the method that defines the relationship in your Model
            'entity' => 'seances', // the method that defines the relationship in your Model
            'attribute' => 'start_time', // foreign key attribute that is shown to user
            'model' => 'App\Models\Seance', // foreign key model
            // 'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);

        $this->crud->addField([
            'name' => 'service_2',
            'value' => '<div class="col-md-12"><h3>Дополнительная информация</h3></div>',
            'type' => 'custom_html',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'orig_title',
            'label' => 'Оригинальное название',
            'type' => 'text',
            'colspan' => '10',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'country',
            'label' => 'Страна',
            'type' => 'text',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'year',
            'label' => 'Год',
            'type' => 'number',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'language',
            'label' => 'Язык',
            'type' => 'text',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'chrono',
            'label' => 'Хронометраж (мин)',
            'type' => 'number',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'carrier',
            'label' => 'Носитель',
            'type' => 'select_from_array',
            'options' => [
                'dcp' => 'DCP',
                '35mm' => '35 мм',
                'blurey' => 'Blu-ray',
            ],
            'allows_null' => true,
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'subtitles',
            'label' => 'Субтитры',
            'type' => 'select_from_array',
            'options' => [
                'yes' => 'Да',
                'no' => 'Нет',
            ],
            'allows_null' => false,
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'age_restrictions',
            'label' => 'Возр. ограничения ',
            'type' => 'number',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'director',
            'label' => 'Режиссёр',
            'type' => 'text',
            'colspan' => '6',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'writtenby',
            'label' => 'Сценарист',
            'type' => 'text',
            'colspan' => '6',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'operator',
            'label' => 'Оператор',
            'type' => 'text',
            'colspan' => '6',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'producer',
            'label' => 'Продюсер',
            'type' => 'text',
            'colspan' => '6',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'actors',
            'label' => 'Актеры в главных ролях',
            'type' => 'textarea',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'awards',
            'label' => 'Награды',
            'type' => 'text',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'link',
            'label' => 'Ссылка',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'service_3',
            'value' => '<div class="col-md-12"><h3>Мета-инфо</h3></div>',
            'type' => 'custom_html',
        ]);

        $this->crud->addField([ // TEXT
            'name' => 'meta_title',
            'label' => 'Meta-Title',
            'hint' => 'Если не заполнять, примет значение название события',
            'fake' => true,
            'store_in' => 'meta',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'meta_description',
            'label' => 'Meta-Description',
            'hint' => 'Если не заполнять, примет значение перых 30 слов из описания события',
            'fake' => true,
            'store_in' => 'meta',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'meta_keywords',
            'label' => 'Meta-Keywords',
            'fake' => true,
            'store_in' => 'meta',
        ]);

        // actors
        // awards
        // videos
        // images
        // properties

        // $this->crud->addField([ // TEXT
        //     'name'  => 'date',
        //     'label' => 'Date',
        //     'type'  => 'date',
        //     'value' => date('Y-m-d')
        // ], 'create');
        // $this->crud->addField([ // TEXT
        //     'name'  => 'date',
        //     'label' => 'Date',
        //     'type'  => 'date'
        // ], 'update');

        // $this->crud->addField([ // SELECT
        //     'label'     => "Category",
        //     'type'      => 'select2',
        //     'name'      => 'category_id',
        //     'entity'    => 'category',
        //     'attribute' => 'name',
        //     'model'     => "App\Models\Category"
        // ]);
        // $this->crud->addField([ // Select2Multiple = n-n relationship (with pivot table)
        //     'label'     => "Tags",
        //     'type'      => 'select2_multiple',
        //     'name'      => 'tags',           // the method that defines the relationship in your Model
        //     'entity'    => 'tags',           // the method that defines the relationship in your Model
        //     'attribute' => 'name',           // foreign key attribute that is shown to user
        //     'model'     => "App\Models\Tag", // foreign key model
        //     'pivot'     => true             // on create&update, do you need to add/delete pivot table entries?
        // ]);
        // $this->crud->addField([ // ENUM
        //     'name'  => 'status',
        //     'label' => "Status",
        //     'type'  => 'enum'
        // ]);
        // $this->crud->addField([ // CHECKBOX
        //     'name'  => 'featured',
        //     'label' => "Featured item",
        //     'type'  => 'checkbox'
        // ]);


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
