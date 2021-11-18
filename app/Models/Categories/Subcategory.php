<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'sub_categories';

    protected $fillable = ['name_en','name_ar','category_id','image_name','image_path'];

    protected $hidden = [];

    protected $guarded = [];
}
