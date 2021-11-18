<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'buyer_notifications';

    protected $fillable = ['type','seller_id','buyer_id','icon','data'];

    protected $hidden = ['seller_id','buyer_id'];
}
