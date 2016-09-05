<?php
namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

use Propaganistas\LaravelCacheSupport\Traits\EloquentCacheable;

class Tag extends Model
{
    use CrudTrait;
    use EloquentCacheable;

    protected $table    = 'tags';
    public $timestamps  = true;
    protected $fillable = ['name'];

}
