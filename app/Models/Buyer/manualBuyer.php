<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Model;

class manualBuyer extends Model
{
    protected $table = 'manual_users';

    protected $hidden = [];

    protected $fillable = ["name","tax","phone","address","seller_id"];
}
