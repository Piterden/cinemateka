<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Stichoza\GoogleTranslate\TranslateClient;

class Event extends Model implements SluggableInterface
{
    use CrudTrait;
    use SluggableTrait;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
     */
    protected $table = 'events';
    // protected $guarded = ['id'];
    // protected $hidden = ['id'];
    protected $fillable = [
        'published',
        'title',
        'slug',
        'category_id',
        'description',
        'orig_title',
        'year',
        'country',
        'carrier',
        'language',
        'subtitles',
        'director',
        'writtenby',
        'operator',
        'producer',
        'link',
        'chrono',
        'age_restrictions',
        'meta',
        'actors',
        'awards',
        'videos',
        'images',
        'properties',
    ];
    protected $fakeColumns = [
        'meta',
        'videos',
        'actors',
        'awards',
        'properties',
    ];
    protected $sluggable = [
        'build_from' => 'translated_slug',
        'save_to' => 'slug',
        'on_update' => true,
        'unique' => true,
    ];
    protected $dates = ['deleted_at', 'created_at', 'edited_at'];
    public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
     */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
     */
    /**
     * Может иметь много сеансов.
     */
    public function seances()
    {
        return $this->hasMany('App\Models\Seance');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    // public function tags()
    // {
    //     return $this->belongsToMany('App\Models\Tag', 'article_tag');
    // }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
     */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
     */
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTranslatedSlugAttribute()
    {
        if (!$this->title || trim($this->title) === "") {
            return "";
        }
        $tr = new TranslateClient(null, 'en');

        return str_slug($tr->translate($this->title));
    }

    // public function getEventTypeAttribute()
    // {
    //     return $this->category()->name;
    // }

    // public function getImageFields()
    // {
    //     return [
    //         'image' => 'event_images/',
    //         'photo' => 'event_photos/',
    //         'other' => ['other_images/', function ($directory, $originalName, $extension) {
    //             return $originalName;
    //         }, ],
    //     ];
    // }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
     */

    /*
     * Image attribute mutator.
     *
     * @param [type] $value [description]
     */
    // public function setImageAttribute($value)
    // {
    //     $value = explode(',', $value);
    //
    //     return json_encode($value);
    // }
}
