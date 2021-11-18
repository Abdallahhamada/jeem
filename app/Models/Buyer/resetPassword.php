<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Model;

class resetPassword extends Model
{
    protected $table = 'password_buyer_reset';

    protected $fillable = ['email','token'];

    protected $hidden = [];

}
