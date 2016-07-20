<?php

namespace App\Models;

use Geocoder;
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
        'place_site',
        'place_email',
        'place_phone'
    ];
    protected $fakeColumns = ['properties'];
    protected $dates       = ['created_at', 'edited_at', 'deleted_at'];
    public $timestamps     = true;
    protected $appends     = ['position'];

    /**
     * |--------------------------------------------------------------------------
     * | FUNCTIONS
     * |--------------------------------------------------------------------------
     */
    public function getGoogleGeocoderResponse($address)
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

    public function getGeoPositionJson($results = [])
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
    public function getPositionAttribute($value)
    {
        $res = $this->getGoogleGeocoderResponse($this->address);
        if (!$value || $value == '{"lat":"","lng":""}')
        {
            if (!$address = $this->address)
            {
                return $value;
            }
            $results = $this->getGoogleGeocoderResponse($address);
            return $this->getGeoPositionJson($results);
        }
    }

    /**
     * --------------------------------------------------------------------------
     *  MUTATORS
     * --------------------------------------------------------------------------
     */

}
