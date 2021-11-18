<?php

namespace App\Models\Tag;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['seller_id','title','image_name','image_path','admin_status','tag_status'];

    protected $hidden = ['seller_id','created_at','updated_at','image_path','image_name'];

    public function seller() {

        return $this->belongsTo('App\Models\Seller\Seller','seller_id','id');
    }

    public function toggleStatus (){

        $this->update([

            'tag_status' => DB::raw('NOT tag_status')

        ]);

        return $this->status;
    }
}
