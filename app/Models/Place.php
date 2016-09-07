<?php
namespace App\Models;

use Geocoder;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Propaganistas\LaravelCacheSupport\Traits\EloquentCacheable;

class Place extends Model
{
    use CrudTrait;
    use SoftDeletes;
    // use EloquentCacheable;

    protected $table    = 'places';
    protected $fillable = [
        'published',
        'title',
        'description',
        'address',
        'metro',
        'images',
        'place_site',
        'place_email',
        'place_phone',
        'place_type',
    ];
    public $timestamps = true;

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

    public function seances()
    {
        $this->hasMany('App\Model\Seances');
    }

    public function setAddressAttribute($value)
    {
        if (trim($value))
        {
            $results                      = $this->googleGeocoderResponse($value);
            $this->attributes['position'] = $this->geoPositionJson($results);
        }
        $this->attributes['address'] = $value;
        return $value;
    }
}
