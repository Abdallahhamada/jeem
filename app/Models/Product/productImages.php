<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class productImages extends Model
{
    protected $table = 'product_images';

    protected $fillable = ['seller_id','product_id','image_name','image_path'];
}
