<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = ['name','email','message'];

    protected $hidden = [];
}
