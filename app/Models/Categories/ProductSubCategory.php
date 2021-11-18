<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    protected $table = 'product_sub_categories';

    protected $fillable = ['name_en','name_ar','category_id','category_sub_id','image_name','image_path'];

    protected $hidden = [];

    protected $guarded = [];

    public function seller(){

        return $this->belongsTo('App\Models\Seller\Seller','category_id');
    }
}
