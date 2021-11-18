<?php

namespace App\Models\Seller;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Seller extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    protected $guard_name = 'seller';

    protected $table = 'sellers';

    protected $fillable  = [
        'name','email','password','phone','otp_phone','otp_email','carousel_status','tag_status','meeting_status','verified','active','unique_id','token','category_id','country','city','pincode','state','address','image_path','image_name','descri'
    ];

    protected $hidden = [
        'remember_token','password','verified','deleted_at','created_at','updated_at','otp_phone','unique_id','email_verified_at','login','otp_email','category_id','token'
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

    public function products(){

        return $this->hasMany('App\Models\Product\Product','seller_id');
    }

    public function tags(){

        return $this->hasMany('App\Models\Tag\Tag','seller_id');
    }

    public function posts(){

        return $this->hasMany('App\Models\Post\Post','seller_id');
    }

    public function carousels(){

        return $this->hasMany('App\Models\Carousel\Carousel','seller_id');
    }

    public function subseller(){

        return $this->hasMany('App\Models\Seller\Subseller','seller_id');
    }

    public function invoice(){

        return $this->hasMany('App\Models\Invoice\Invoice','seller_id');
    }


    public static function boot() {

        parent::boot();

        static::deleting(function($user) {

             $user->products()->delete();

             $user->tags()->delete();

             $user->posts()->delete();

             $user->carousels()->delete();

             $user->subseller()->delete();

             $user->invoice()->delete();
        });
    }
}
