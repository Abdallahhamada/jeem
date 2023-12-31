<?php

namespace App\Models\Seller;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Subseller extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    protected $table = 'sub_sellers';

    protected $guard_name = 'subseller';

    protected $fillable = [
        'name','email','password','seller_id'
    ];

    protected $hidden = [
        'password','remember_token','created_at','updated_at','seller_id',
    ];

    protected $casts = [

    ];

    protected $guarded = ['subseller'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
