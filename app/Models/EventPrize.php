<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class EventPrize extends Model
{
    //
    protected $fillable=['name','description','user_id','events_id','num','random'];
    
    //活动名称
    public function eventName()
    {
        return $this->belongsTo(Event::class,'events_id','id');
    }
    //商家账号
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    //奖品的概率
    public function pro()
    {
        return $this->belongsTo(Probability::class,'random','id');
    }
}
