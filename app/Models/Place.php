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
        'position'
    ];
    protected $fakeColumns = ['properties'];
    protected $dates   = ['created_at', 'edited_at', 'deleted_at'];
    public $timestamps = true;
    // protected $casts = [
    //     'properties' => 'string',
    //     'position'   => 'string',
    // ];

    /**
     * |--------------------------------------------------------------------------
     * | FUNCTIONS
     * |--------------------------------------------------------------------------
     */
    public function getGoogleGeocoderResponse($address)
    {
        // dd($address);
        $param    = ['address' => 'г. Санкт-Петербург, '.$address];
        $response = \Geocoder::geocode('json', $param);
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

    // // public function getPositionArray($posJson)
    // // {
    // //     return json_decode($posJson, true);
    // // }

    public function jsonEncode($array)
    {
        return json_encode($array, /*JSON_HEX_TAG |*/JSON_HEX_APOS |
            JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
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
    // public function getLatAttribute($value)
    // {
    //     $posArr = $this->getPositionArray($this->attributes['position']);
    //     return $posArr['lat'];
    // }

    // public function getLngAttribute($value)
    // {
    //     $posArr = $this->getPositionArray($this->attributes['position']);
    //     return $posArr['lng'];
    // }

    // public function getPositionAttribute($value)
    // {
    //     if (!$value || $value == '{"lat":"","lng":""}')
    //     {
    //         if (!$address = $this->address)
    //         {
    //             return $value;
    //         }
    //         $results = $this->getGoogleGeocoderResponse($address);
    //         return $this->getGeoPositionJson($results);
    //     }
    // }

    /**
     * --------------------------------------------------------------------------
     *  MUTATORS
     * --------------------------------------------------------------------------
     */
    public function setAddressAttribute($value)
    {
        $results                      = $this->getGoogleGeocoderResponse($value);
        $this->attributes['position'] = $this->getGeoPositionJson($results);
        return $value;
    }

    // public function setLatAttribute($value)
    // {
    //     $posArr = $this->getPositionArray($this->attributes['position']);
    //     $posArr['lat'] = floatval($value);
    //     $this->attributes['position'] = $this->jsonEncode($posArr);
    //     return $value;
    // }

    // public function setLngAttribute($value)
    // {
    //     $posArr = $this->getPositionArray($this->attributes['position']);
    //     $posArr['lng'] = floatval($value);
    //     $this->attributes['position'] = $this->jsonEncode($posArr);
    //     return $value;
    // }
}
