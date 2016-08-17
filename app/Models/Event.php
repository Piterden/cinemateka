<?php
namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Propaganistas\LaravelCacheSupport\Traits\EloquentCacheable;

class Event extends Model
{
    use CrudTrait;
    use SoftDeletes;
    // use EloquentCacheable;

    protected $table = 'events';
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
    protected $dates   = ['deleted_at'];
    public $timestamps = true;
    protected $casts   = ['year' => 'integer'];

    public function seances()
    {
        return $this->hasMany('App\Models\Seance');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

}
