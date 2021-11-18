<?php

namespace App\Models\Review;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = ['buyer_id','product_id','content','rating'];

    protected $hidden = ['buyer_id','product_id','created_at','updated_at'];

    public function products(){

        return $this->belongsTo('App\Models\Product\Product','product_id','id');
    }

    public function buyer(){

        return $this->belongsTo('App\Models\Buyer\Buyer','buyer_id','id');
    }
}
