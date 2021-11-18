<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class messageSeller extends Model
{
    protected $table = 'admin_seller_messages';

    protected $fillable = ['seller_id','count'];

    protected $hidden = ['seller_id'];

    public function seller(){

        return $this->belongsTo('App\Models\Seller\Seller','seller_id','id');
    }
}
