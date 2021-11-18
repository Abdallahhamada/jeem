<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = ['buyer_id','seller_id','admin_id','message'];

    protected $hidden = [
        "buyer_id",
        "seller_id",
        'admin_id'
    ];

    public function buyer(){

        return $this->belongsTo('App\Models\Buyer\Buyer','buyer_id','id');
    }

    public function seller(){

        return $this->belongsTo('App\Models\Seller\Seller','seller_id','id');
    }

    public function admin(){

        return $this->belongsTo('App\Models\Admin\Admin','admin_id','id');
    }
}
