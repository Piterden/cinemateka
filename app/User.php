<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use CrudTrait;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Generate Gravatar image for user
     * @param  string
     * @return string
     */
    public function getImageAttribute($value)
    {
        $gravemail = md5(
            strtolower(
                trim($this->email)
            )
        );

        return 'https://www.gravatar.com/avatar/'
            .$gravemail.'?s=128&d=mm';
    }
}
