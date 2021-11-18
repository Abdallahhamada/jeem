<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class commentPost extends Model
{
    protected $table = 'comment_post';

    protected $fillable = ['comment','like','post_id','buyer_id'];

    protected $hidden = ['post_id','buyer_id','updated_at','created_at'];

    public function buyer(){

        return $this->belongsTo('App\Models\Buyer\Buyer','buyer_id');
    }
}
