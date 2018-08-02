<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    //获取商家账号
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    //活动id对应一个活动账号
    public function eventName()
    {
        return $this->hasOne(Event::class,'id','events_id');
    }
}
