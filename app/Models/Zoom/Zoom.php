<?php

namespace App\Models\Zoom;

use Illuminate\Database\Eloquent\Model;

class Zoom extends Model
{
    protected $table = 'zoom_meetings';

    protected $fillable = ['zoom_id', 'topic','duration','status','start_time','password','status','start_url','join_url','start_time','buyer_id','product_id','seller_id','admin_id'];

    protected $hidden = ['buyer_id','product_id','created_at','updated_at','seller_id','password','join_url','admin_id'];

    public function buyer(){

        return $this->belongsTo('App\Models\Buyer\Buyer','buyer_id','id');
    }

    public function seller(){

        return $this->belongsTo('App\Models\Seller\Seller','seller_id','id');
    }

    public function admin(){

        return $this->belongsTo('App\Models\Admin\Admin','admin_id','id');
    }

    public function product(){

        return $this->belongsTo('App\Models\Product\Product','product_id','id');
    }
}
