<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['code','price','discount','counts','buyer_id','product_id','seller_id','delivery_id','address_id','status'];

    protected $hidden = ['id','updated_at','seller_id','buyer_id'];

    public function product(){

        return $this->belongsTo('App\Models\Product\Product','product_id','id');
    }

    public function seller(){

        return $this->belongsTo('App\Models\Seller\Seller','seller_id','id');
    }

    public function buyer(){

        return $this->belongsTo('App\Models\Buyer\Buyer','buyer_id','id');
    }

    public function delivery(){

        return $this->belongsTo('App\Models\DeliveryStatus\DeliveryStatus','delivery_id','id');
    }

    public function address(){

        return $this->belongsTo('App\Models\Buyer\Address','address_id','id');
    }

}
