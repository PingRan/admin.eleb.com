<?php

namespace App;

use App\Models\Shop;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password',
//    ];
    protected $fillable=['name','email','password','status','rememberToken','shop_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

     //获取对应的店铺名字
//    public function shop()
//    {
//        return $this->hasMany(Shop::class,'user_id','id');
//    }
}
