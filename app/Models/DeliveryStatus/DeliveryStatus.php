<?php

namespace App\Models\DeliveryStatus;

use Illuminate\Database\Eloquent\Model;

class DeliveryStatus extends Model
{
    protected $table = 'delivery_status';

    protected $fillable = ['name_en','name_ar'];

    protected $hidden = ['created_at','updated_at'];
}
