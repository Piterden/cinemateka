<?php
namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Propaganistas\LaravelCacheSupport\Traits\EloquentCacheable;

class Program extends Model
{
    use CrudTrait;
    use SoftDeletes;
    use EloquentCacheable;

    protected $table    = 'programs';
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
    protected $fakeColumns = ['meta', 'properties'];
    protected $dates       = ['start_date', 'end_date'];
    public $timestamps     = true;

    public function seances()
    {
        return $this->hasMany('App\Models\Seance');
    }

    public function getStartDateAttribute($value)
    {
        return $this->seances()->min('start_time');
    }

    public function getEndDateAttribute($value)
    {
        return $this->seances()->max('start_time');
    }

}
