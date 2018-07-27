<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $fillable=['member_id','province','city','county','address','tel','name','is_default'];
}
