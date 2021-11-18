<?php

namespace App\Models\Voucher;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = "voucher";

    protected $fillable = ['seller_id','name','check','price','receiver','for'];

    protected $hidden = [];
}
