<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ShopCategory extends Model
{
    //
    protected $fillable=['img','name','status'];

    public function img()
    {
        return Storage::url($this->img);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class,'shop_category_id','id');
    }

}
