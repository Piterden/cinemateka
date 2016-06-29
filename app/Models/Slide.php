<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use CrudTrait;

    /**
     * |--------------------------------------------------------------------------
     * | GLOBAL VARIABLES
     * |--------------------------------------------------------------------------
     */

    protected $table      = 'slides';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    // protected $guarded = ['id'];
    protected $fillable    = ['title', 'src', 'caption', 'slider', 'published'];
    protected $fakeColumns = ['caption_title', 'caption_content'];
    // protected $hidden = [];
    protected $dates = ['deleted_at', 'created_at', 'edited_at'];
    protected $casts = ['caption' => 'array'];

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
    public function category()
    {
        return $this->belongsTo('App\Model\Category');
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
