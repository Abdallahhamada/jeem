<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'seller_notifications';

    protected $fillable = ['type','seller_id','buyer_id','icon','data'];

    protected $hidden = ['seller_id','buyer_id'];
}
