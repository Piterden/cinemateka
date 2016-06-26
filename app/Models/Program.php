<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Program extends Model implements SluggableInterface
{
    use CrudTrait;
    use SluggableTrait;
    use SoftDeletes;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'programs';
    // protected $guarded = ['id'];
    // protected $hidden = [];
    protected $fillable = [
        'title',
        'slug',
        'description',
        'slogan',
        'meta',
        'videos',
        'images',
        'properties',
    ];
    protected $fakeColumns = [
        'meta',
        'videos',
        'images',
        'properties',
    ];
    protected $sluggable = [
        'build_from' => 'slug_or_title',
        'save_to' => 'slug',
        'on_update' => true,
        'unique' => true,
    ];
    protected $dates = [
        'created_at',
        'edited_at',
        'deleted_at',
        'start_date',
        'end_date',
    ];
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
    public function seances()
    {
        return $this->hasMany('App\Models\Seance');
    }

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
    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    // public function getStartDateAttribute()
    // {
    //     return $this->seances()->min('start_time');
    // }
    //
    // public function getEndDateAttribute()
    // {
    //     return $this->seances()->max('start_time');
    // }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
