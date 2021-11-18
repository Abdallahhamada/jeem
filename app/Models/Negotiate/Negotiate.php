<?php

namespace App\Models\Negotiate;

use Illuminate\Database\Eloquent\Model;

class Negotiate extends Model
{
    protected $table = 'order_negotiate_price';

    protected $fillable = ['price','code','notes','buyer_id','seller_id','product_id','count'];

    protected $hidden = ['updated_at','created_at','seller_id','buyer_id'];

    public function buyer(){

        return $this->belongsTo('App\Models\Buyer\Buyer','buyer_id','id');
    }

    public function seller(){

        return $this->belongsTo('App\Models\Seller\Seller','seller_id','id');
    }

    public function orders(){

        return $this->belongsTo('App\Models\Order\Order','code','code');
    }

    public function product(){

        return $this->belongsTo('App\Models\Product\Product','product_id','id');
    }
}
