<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Stichoza\GoogleTranslate\TranslateClient;
// use Cviebrock\EloquentSluggable\SluggableTrait;
// use Cviebrock\EloquentSluggable\SluggableInterface;

class Program extends Model /*implements SluggableInterface*/
{
    use CrudTrait;
    // use SluggableTrait;
    use SoftDeletes;

    /**
     * |--------------------------------------------------------------------------
     * | GLOBAL VARIABLES
     * |--------------------------------------------------------------------------
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
        'press_materials',
    ];
    protected $fakeColumns = [
        'meta',
        'videos',
        'images',
        'properties',
    ];
    protected $dates = [
        'created_at',
        'edited_at',
        'deleted_at',
        'start_date',
        'end_date',
    ];
    public $timestamps = true;

    /**
     * |--------------------------------------------------------------------------
     * | FUNCTIONS
     * |--------------------------------------------------------------------------
     */

    /**
     * |--------------------------------------------------------------------------
     * | RELATIONS
     * |--------------------------------------------------------------------------
     */
    public function seances()
    {
        return $this->hasMany('App\Models\Seance');
    }

    /**
     * |--------------------------------------------------------------------------
     * | SCOPES
     * |--------------------------------------------------------------------------
     */

    /**
     * |--------------------------------------------------------------------------
     * | ACCESORS
     * |--------------------------------------------------------------------------
     */
    public function getStartDateAttribute($value)
    {
        return $this->seances()->min('start_time');
    }

    public function getEndDateAttribute($value)
    {
        return $this->seances()->max('start_time');
    }

    /**
     * |--------------------------------------------------------------------------
     * | MUTATORS
     * |--------------------------------------------------------------------------
     */
}
