<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class manualProduct extends Model
{
    protected $table = 'manual_products';

    protected $fillable = ["buyer_id","title","descri","price","discount","count","total"];

    protected $hidden = [];

    public function buyer(){

        return $this->belongsTo('App\Models\Buyer\manualBuyer','buyer_id','id');
    }

}
