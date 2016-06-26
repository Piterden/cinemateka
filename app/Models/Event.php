<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

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
        'event_type',
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
        'actors',
        'awards',
        'properties',
    ];
    protected $sluggable = [
        'build_from' => 'slug_or_title',
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

    // public function category()
    // {
    //     return $this->belongsTo('App\Models\Category', 'category_id');
    // }

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
     * Псевдоним создается автоматически.
     *
     * @TODO Транслитерация псевдонимов
     */
    public function getSlugOrTitleAttribute()
    {
        if ('' != $this->slug) {
            return $this->slug;
        }

        return $this->title;
    }

    public function getImagesAttribute($value)
    {
        if (empty($value)) $value = json_encode([]);
        $array = json_decode($value);

        return implode(',', $array);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
     */

    /**
     * Featured attribute mutator.
     *
     * When setting an Article as featured,
     * remove the featured attribute
     * from all other Articles.
     *
     * @param [type] $value [description]
     */
    public function setImageAttribute($value = '')
    {
        $value = explode(',', $value);

        return json_encode($value);
    }
}
