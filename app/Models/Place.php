<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use CrudTrait;
    use SoftDeletes;

    /**
     * |--------------------------------------------------------------------------
     * | GLOBAL VARIABLES
     * |--------------------------------------------------------------------------
     */

    protected $table = 'places';
    // protected $guarded = ['id'];
    // protected $hidden = [];
    protected $fillable = [
        'published',
        'title',
        'description',
        'address',
        'metro',
        'images',
        'properties',
        'site',
        'email',
        'phone',
        'place_type',
    ];
    protected $fakeColumns = ['properties'];
    protected $dates   = ['created_at', 'edited_at', 'deleted_at'];
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
        $this->hasMany('App\Model\Seances');
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

    /**
     * |--------------------------------------------------------------------------
     * | MUTATORS
     * |--------------------------------------------------------------------------
     */
}
