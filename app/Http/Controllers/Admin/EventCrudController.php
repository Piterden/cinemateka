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

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name'  => 'created_at',
            'label' => 'Date',
            'type'  => 'date',
        ]);
        $this->crud->addColumn([
            'name'  => 'published',
            'label' => 'Status',
        ]);
        $this->crud->addColumn([
            'name'  => 'title',
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

        // ------ CRUD FIELDS
        $this->crud->addField([ // TEXT
            'name'        => 'title',
            'label'       => 'Title',
            'type'        => 'text',
            'placeholder' => 'Your title here',
        ]);
        $this->crud->addField([
            'name'  => 'slug',
            'label' => 'Slug (URL)',
            'type'  => 'text',
            'hint'  => 'Will be automatically generated from your title, if left empty.',
            // 'disabled' => 'disabled'
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'orig_title',
            'label' => 'Original Title',
            'type'  => 'text',
        ]);
        $this->crud->addField([ // Select2Multiple = n-n relationship (with pivot table)
            'label'     => 'Seances',
            'type'      => 'select2_multiple',
            'name'      => 'seances', // the method that defines the relationship in your Model
            'entity'    => 'seances', // the method that defines the relationship in your Model
            'attribute' => 'start_time', // foreign key attribute that is shown to user
            'model'     => 'App\Models\Seance', // foreign key model
            'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'year',
            'label' => 'Year',
            'type'  => 'text',
        ]);
        $this->crud->addField([ // select_from_array
            'name'        => 'event_type',
            'label'       => 'Event type',
            'type'        => 'select_from_array',
            'options'     => [
                'movie'      => 'Фильм',
                'lecture'    => 'Лекция',
                'exhibition' => 'Выставка',
                'conference' => 'Конференция',
            ],
            'allows_null' => false,
        ]);
        $this->crud->addField([ // WYSIWYG
            'name'        => 'description',
            'label'       => 'Description',
            'type'        => 'ckeditor',
            'placeholder' => 'Your textarea text here',
        ]);
        $this->crud->addField([ // CHECKBOX
            'name'  => 'published',
            'label' => 'Published',
            'type'  => 'checkbox',
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'country',
            'label' => 'Country',
            'type'  => 'text',
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'carrier',
            'label' => 'Carrier',
            'type'  => 'text',
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'language',
            'label' => 'Language',
            'type'  => 'text',
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'subtitles',
            'label' => 'Subtitles',
            'type'  => 'text',
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'director',
            'label' => 'Director',
            'type'  => 'text',
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'writtenby',
            'label' => 'Written by',
            'type'  => 'text',
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'operator',
            'label' => 'Operator',
            'type'  => 'text',
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'producer',
            'label' => 'Producer',
            'type'  => 'text',
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'link',
            'label' => 'Link',
            'type'  => 'text',
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'chrono',
            'label' => 'Chrono',
            'type'  => 'number',
        ]);
        $this->crud->addField([ // TEXT
            'name'  => 'age_restrictions',
            'label' => 'Age Restrictions',
            'type'  => 'number',
        ]);
        $this->crud->addField([ // TEXT
            'name'     => 'meta_title',
            'label'    => 'Meta Title',
            'fake'     => true,
            'store_in' => 'meta',
        ]);
        $this->crud->addField([ // TEXT
            'name'     => 'meta_description',
            'label'    => 'Meta Description',
            'fake'     => true,
            'store_in' => 'meta',
        ]);
        $this->crud->addField([ // TEXT
            'name'     => 'meta_keywords',
            'label'    => 'Meta Keywords',
            'fake'     => true,
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

        // $this->crud->addField([ // Image
        //     'name'  => 'image',
        //     'label' => 'Image',
        //     'type'  => 'browse'
        // ]);
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
