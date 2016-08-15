<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\EventRequest as StoreRequest;
use App\Http\Requests\EventRequest as UpdateRequest;

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
            'name'    => 'title',
            'label'   => 'Название',
        ]);
        $this->crud->addColumn([
            'name'  => 'published',
            'label' => 'Статус',
            'value' => 1,
        ]);
        $this->crud->addColumn([
            'name'  => 'created_at',
            'label' => 'Добавлено',
            'type'  => 'date',
        ]);
        $this->crud->addColumn([
            'name'        => 'category_id',
            'label'       => 'Тип события',
            'type'        => 'select',
            'allows_null' => false,
            'entity'      => 'category',
            'colspan'     => '2',
            'attribute'   => 'name',
            'model'       => "App\Models\Category",
        ]);

        /*
         *  ------ CRUD FIELDS
         */
        $this->crud->addField([ // TEXT
            'name'        => 'title',
            'label'       => 'Заголовок',
            'type'        => 'text',
            'placeholder' => 'Название события',
            'colspan'     => '10',
            'v-model'     => 'title',
        ]);
        $this->crud->addField([ // select
            'name'        => 'category_id',
            'label'       => 'Тип события',
            'type'        => 'select',
            'allows_null' => false,
            'entity'      => 'category',
            'colspan'     => '2',
            'attribute'   => 'name',
            'model'       => "App\Models\Category",
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
        $this->crud->addField([ // CHECKBOX
            'name'    => 'published',
            'label'   => 'Опубликованно',
            'type'    => 'checkbox',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // CHECKBOX
            'name'    => 'wide',
            'label'   => 'Широкая плитка',
            'type'    => 'checkbox',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // WYSIWYG
            'name'        => 'description',
            'label'       => 'Описание',
            'type'        => 'ckeditor', //summernote
            'placeholder' => 'Введите описание события',
            'colspan'     => '12',
        ]);
        $this->crud->addField([ // WYSIWYG
            'name'    => 'press_materials',
            'label'   => 'Пресс-материалы',
            'type'    => 'ckeditor',
            'colspan' => '12',
        ]);
        $this->crud->addField([ // Select2Multiple = n-n relationship (with pivot table)
            'label'   => 'Сеансы',
            'type'    => 'select_seance_multiple',
            'name'    => 'seances', // the method that defines the relationship in your Model
            'colspan' => '12',
        ]);
        $this->crud->addField([
            'name'  => 'service_2',
            'value' => '<div class="col-md-12"><h3>Дополнительная информация</h3></div>',
            'type'  => 'custom_html',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'orig_title',
            'label'   => 'Оригинальное название',
            'type'    => 'text',
            'colspan' => '10',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'country',
            'label'   => 'Страна',
            'type'    => 'text',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'year',
            'label'   => 'Год',
            'type'    => 'number',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'language',
            'label'   => 'Язык',
            'type'    => 'text',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'chrono',
            'label'   => 'Хронометраж (мин)',
            'type'    => 'number',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name'        => 'carrier',
            'label'       => 'Носитель',
            'type'        => 'select_from_array',
            'options'     => [
                'dcp'    => 'DCP',
                '35mm'   => '35 мм',
                'blurey' => 'Blu-ray',
            ],
            'allows_null' => true,
            'colspan'     => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name'        => 'subtitles',
            'label'       => 'Субтитры',
            'type'        => 'select_from_array',
            'options'     => [
                'yes' => 'Да',
                'no'  => 'Нет',
            ],
            'allows_null' => false,
            'colspan'     => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'age_restrictions',
            'label'   => 'Возр. ограничения ',
            'type'    => 'number',
            'colspan' => '2',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'director',
            'label'   => 'Режиссёр',
            'type'    => 'text',
            'colspan' => '6',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'writtenby',
            'label'   => 'Сценарист',
            'type'    => 'text',
            'colspan' => '6',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'operator',
            'label'   => 'Оператор',
            'type'    => 'text',
            'colspan' => '6',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'producer',
            'label'   => 'Продюсер',
            'type'    => 'text',
            'colspan' => '6',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'actors',
            'label'   => 'Актеры в главных ролях',
            'hint'    => 'Пример заполнения - ["Татьяна Друбич, Александр Баширов, Виктор Цой"]',
            'type'    => 'text',
            // 'type'      => 'repeater_text',
            'colspan' => '12',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'awards',
            'label'   => 'Награды',
            'type'    => 'text',
            // 'type'  => 'repeater_text',
            'colspan' => '6',
        ]);
        $this->crud->addField([ // TEXT
            'name'    => 'link',
            'label'   => 'Ссылка',
            'type'    => 'text',
            'colspan' => '6',
        ]);
        $this->crud->addField([
            'name'  => '2',
            'label' => 'SEO данные',
            'type'  => 'separator',
        ]);
        $this->crud->addField([ // TEXT
            'name'     => 'meta_title',
            'label'    => 'Meta-Title',
            'hint'     => 'Если не заполнять, примет значение название события',
            'colspan'  => '6',
            'fake'     => true,
            'store_in' => 'meta',
        ]);
        $this->crud->addField([
            'name'     => 'slug',
            'label'    => 'ЧПУ (URL)',
            'type'     => 'text',
            'hint'     => 'Если не заполнять, создастся автоматически',
            'colspan'  => '6',
            'cssclass' => 'input-slug',
            'v-model'  => 'slug',
            '@keyup'   => '$root.doTranslit($event)',
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
    }

    public function store(StoreRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => ['required', 'max:255'],
            'slug'        => ['required', 'unique:events', 'max:255'],
            'category_id' => ['required'],
        ], [
            'title.required'       => 'Необходимо указать заголовок',
            'slug.required'        => 'Необходимо указать псевдоним',
            'category_id.required' => 'Необходимо указать категорию',
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
            'title'       => ['required', 'max:255'],
            'slug'        => ['required', 'max:255'],
            'category_id' => ['required'],
        ], [
            'title.required'       => 'Необходимо указать заголовок',
            'slug.required'        => 'Необходимо указать псевдоним',
            'category_id.required' => 'Необходимо указать категорию',
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
