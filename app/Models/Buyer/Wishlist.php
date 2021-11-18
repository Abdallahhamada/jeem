<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table  = "wishlist";

    protected $fillable = ['buyer_id','product_id'];

    protected $hidden = [];

    public function product(){

        return $this->belongsTo('App\Models\Product\Product','product_id','id');
    }
}
