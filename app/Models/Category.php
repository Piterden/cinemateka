<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
// use Propaganistas\LaravelCacheSupport\Traits\EloquentCacheable;

class Category extends Model
{
    use CrudTrait;
    // use EloquentCacheable;

    protected $table      = 'categories';
    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category');
    }

    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    public function slides()
    {
        return $this->hasMany('App\Models\Slide');
    }

}
