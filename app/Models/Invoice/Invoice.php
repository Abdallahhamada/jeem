<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    protected $fillable = ['name','image_name','image_path','seller_id','shipping_charge'];

    protected $hidden = ['seller_id','image_name','image_path','created_at','updated_at'];

}
