<?php

namespace App\Models;

use Geocoder;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Propaganistas\LaravelCacheSupport\Traits\EloquentCacheable;

class Place extends Model
{
    use CrudTrait;
    use SoftDeletes;
    use EloquentCacheable;

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
        // 'position',
        // 'properties',
        'place_site',
        'place_email',
        'place_phone',
        'place_type',
    ];
    protected $fakeColumns = ['properties'];
    // protected $dates       = ['created_at', 'edited_at', 'deleted_at'];
    public $timestamps     = true;
    // protected $appends     = ['position'];

    /**
     * |--------------------------------------------------------------------------
     * | FUNCTIONS
     * |--------------------------------------------------------------------------
     */
    public function googleGeocoderResponse($address)
    {
        $param    = ['address' => 'г. Санкт-Петербург, '.$address];
        $response = Geocoder::geocode('json', $param);
        $array    = json_decode($response, true);

        if ($array['status'] == 'OK')
        {
            return $array['results'];
        }
        return [];
    }

    public function geoPositionJson($results = [])
    {
        if (!count($results))
        {
            return $this->jsonEncode(['lat' => '', 'lng' => '']);
        }
        $position = $results[0]['geometry']['location'];

        return $this->jsonEncode($position);
    }

    public function jsonEncode($array)
    {
        return json_encode($array, JSON_HEX_APOS | JSON_HEX_QUOT |
            JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }

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
     * Geocoding
     * @param  [type] $value          [description]
     * @return [type] [description]
     */
    // public function getPositionAttribute($value)
    // {
    // }

    /**
     * --------------------------------------------------------------------------
     *  MUTATORS
     * --------------------------------------------------------------------------
     */
    public function setAddressAttribute($value)
    {
        if (trim($value))
        {
            $results = $this->googleGeocoderResponse($value);
            $this->attributes['position'] = $this->geoPositionJson($results);
        }
        return $value;
    }
}
