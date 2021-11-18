<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "order_address_buyer";

    protected $fillable = ['phone','address','buyer_id','status'];

    protected $hidden = ['created_at','updated_at','buyer_id'];
}
