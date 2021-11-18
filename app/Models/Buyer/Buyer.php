<?php

namespace App\Models\Buyer;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Buyer extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'buyers';

    protected $fillable  = [
        'name','email','password','phone','otp_phone',"image_name","image_path",'unique_id','token','verified','country','city','pincode','state','address'
    ];

    protected $hidden = [
        'remember_token','password','login','otp_phone','email_verified_at','created_at','updated_at','verified','token','image_name','image_path','unique_id'
    ];

    protected $guarded = [];

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
