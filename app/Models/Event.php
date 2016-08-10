<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Propaganistas\LaravelCacheSupport\Traits\EloquentCacheable;

class Event extends Model
{
    use CrudTrait;
    use SoftDeletes;
    use EloquentCacheable;

    /**
     * --------------------------------------------------------------------------
     * GLOBAL VARIABLES
     * --------------------------------------------------------------------------
     */
    protected $table = 'events';
    // protected $guarded = ['id'];
    // protected $hidden = ['id'];
    protected $fillable = [
        'published',
        'wide',
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
        'press_materials',
    ];
    protected $fakeColumns = [
        'meta',
        'properties',
    ];
    protected $dates   = ['deleted_at', 'created_at', 'edited_at'];
    public $timestamps = true;
    protected $casts   = ['year' => 'integer'];

    /**
     * --------------------------------------------------------------------------
     * FUNCTIONS
     * --------------------------------------------------------------------------
     */

    /**
     * --------------------------------------------------------------------------
     * RELATIONS
     * --------------------------------------------------------------------------
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

    /**
     * --------------------------------------------------------------------------
     * SCOPES
     * |--------------------------------------------------------------------------
     */

    /**
     * --------------------------------------------------------------------------
     * ACCESORS
     * --------------------------------------------------------------------------
     */
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

    /**
     * --------------------------------------------------------------------------
     *  MUTATORS
     * --------------------------------------------------------------------------
     */

    /**
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
