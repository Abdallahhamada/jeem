<?php

namespace App\Models\Carousel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Carousel extends Model
{
    protected $table = 'carousels';

    protected $guarded = [];

    protected $fillable = [
        'seller_id','title','subtitle','image_name','image_path','carousel_status','admin_status'
    ];

    protected $hidden = [
        'created_at','updated_at','image_name','image_path'
    ];

    public function toggleStatus (){

        $this->update([

            'carousel_status' => DB::raw('NOT carousel_status')

        ]);

        return $this->carousel_status;
    }

    public function sellers(){

        return $this->belongsTo('App\Models\Seller\Seller','seller_id','id');
    }
}
