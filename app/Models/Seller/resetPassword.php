<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Model;

class resetPassword extends Model
{
    protected $table = 'password_seller_resets';

    protected $fillable = ['email','token'];

    protected $hidden = [];
}
