<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

    protected $fillable = ['content','image_name','image_path','seller_id'];

    protected $hidden = ['updated_at','created_at','image_name','image_path','seller_id'];

    public function comments(){

        return $this->hasMany('App\Models\Post\commentPost','post_id','id');
    }

    public function buyer(){

        return $this->belongsTo('App\Models\Buyer\Buyer','buyer_id','id');
    }
}
