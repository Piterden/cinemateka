<?php

namespace App\Http\Controllers\Admin;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ArticleRequest as StoreRequest;
use App\Http\Requests\ArticleRequest as UpdateRequest;
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

        /**
         *  ------ CRUD COLUMNS
         */
        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => 'Date',
            'type' => 'date',
        ]);
        $this->crud->addColumn([
            'name' => 'published',
            'label' => 'Status',
        ]);
        $this->crud->addColumn([
            'name' => 'title',
            'label' => 'Title',
        ]);
        // $this->crud->addColumn([
        //                         'name' => 'featured',
        //                         'label' => "Featured",
        //                         'type' => "model_function",
        //                         'function_name' => 'getFeaturedColumn'
        //                     ]);
        // $this->crud->addColumn([
        //                         'name' => 'event_type',
        //                         'label' => "Event type",
        //                         'type' => 'select_from_array',
        //                         'options' => [
        //                             'movie' => 'Фильм',
        //                             'lecture' => 'Лекция',
        //                             'exhibition' => 'Выставка',
        //                             'conference' => 'Конференция'
        //                         ],
        //                         'allows_null' => false
        //                     ]);

        /**
         *  ------ CRUD FIELDS
         */
        $this->crud->addField([
            'name' => '0',
            'label' => 'Основная информация',
            'type' => 'separator',
            'colspan' => 10
        ]);
        $this->crud->addField([ // CHECKBOX
            'name' => 'published',
            'label' => 'Опубликованно',
            'type' => 'checkbox',
            'colspan' => 2
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'title',
            'label' => 'Заголовок',
            'type' => 'text',
            'placeholder' => 'Название события',
            'cssclass' => '',
        ]);

        $this->crud->addField([ // select_from_array
            'name' => 'event_type',
            'label' => 'Тип события',
            'type' => 'select_from_array',
            'options' => [
                'movie' => 'Фильм',
                'lecture' => 'Лекция',
                'exhibition' => 'Выставка',
                'conference' => 'Конференция',
            ],
            'allows_null' => false,
            'colspan' => 2
        ]);
        $this->crud->addField([ // Image
            'name' => 'images',
            'label' => 'Картинка',
            'type' => 'text',
            'colspan' => 5
        ]);
        $this->crud->addField([ // Image
            'name' => 'videos',
            'label' => 'Видео',
            'type' => 'text',
            'colspan' => 5
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
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);





        $this->crud->addField([
            'name' => '1',
            'label' => 'Дополнительная информация',
            'type' => 'separator',
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'orig_title',
            'label' => 'Оригинальное название',
            'type' => 'text',
            'colspan' => 10
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'country',
            'label' => 'Страна',
            'type' => 'text',
            'colspan' => 2
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'year',
            'label' => 'Год',
            'type' => 'number',
            'colspan' => 2
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'language',
            'label' => 'Язык',
            'type' => 'text',
            'colspan' => 2
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'chrono',
            'label' => 'Хронометраж (мин)',
            'type' => 'number',
            'colspan' => 2
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
            'colspan' => 2
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'subtitles',
            'label' => 'Субтитры',
            'type' => 'select_from_array',
            'options' => [
                'yes' => 'Да',
                'no' => 'Нет',
            ],
            'allows_null' => true,
            'colspan' => 2
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'age_restrictions',
            'label' => 'Возр. ограничения ',
            'type' => 'number',
            'colspan' => 2
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'director',
            'label' => 'Режиссёр',
            'type' => 'text',
            'colspan' => 6
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'writtenby',
            'label' => 'Сценарист',
            'type' => 'text',
            'colspan' => 6
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'operator',
            'label' => 'Оператор',
            'type' => 'text',
            'colspan' => 6
        ]);
        $this->crud->addField([ // TEXT
            'name' => 'producer',
            'label' => 'Продюсер',
            'type' => 'text',
            'colspan' => 6
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
            'name' => '2',
            'label' => 'SEO данные',
            'type' => 'separator',
        ]);
        $this->crud->addField([
            'name' => 'slug',
            'label' => 'ЧПУ (URL)',
            'type' => 'text',
            'hint' => 'Если не заполнять, создастся автоматически',
            // 'disabled' => 'disabled'
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
