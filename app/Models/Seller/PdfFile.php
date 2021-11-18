<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Model;

class PdfFile extends Model
{
    protected $table = 'seller_files';

    protected $fillable = ['path','seller_id'];
}
