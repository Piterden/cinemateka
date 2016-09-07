<?php
namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

// use Propaganistas\LaravelCacheSupport\Traits\EloquentCacheable;

class Slide extends Model
{
    use CrudTrait;
    // use EloquentCacheable;

    protected $table      = 'slides';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable = [
        'slider',
        'published',
        'category_id',
        'title',
        'src',
        'link',
        'caption',
    ];
    protected $fakeColumns = ['caption'];
    protected $dates = ['deleted_at'];
    protected $casts = ['caption' => 'array'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

}
