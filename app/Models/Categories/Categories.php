<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name_en','name_ar','image_name','image_path'];

    protected $hidden = [];

    protected $guarded = [];
}
