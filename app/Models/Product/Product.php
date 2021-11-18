<?php

namespace App\Models\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $guarded = [];

    protected $fillable = [
        'seller_id','title','subtitle','descri','price','discount','count','max_neg','tag_id','carousel_id','category_id','status','total'
    ];

    protected $hidden = [
        'created_at','updated_at','seller_id'
    ];

    public function toggleStatus (){

        $this->update([

            'status' => DB::raw('NOT status')

        ]);

        return $this->status;
    }

    public function seller(){

        return $this->belongsTo('App\Models\Seller\Seller','seller_id','id');
    }
}
