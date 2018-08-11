<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Jobs\SendEmail;
class AuditController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>[],
        ]);
    }
    //审核
    public function audit(Request $request,Shop $shop)
    {

        $shop->update(['status'=>$request->status]);
        session()->flash('success','操作成功');
        //修改店铺状态时  更新缓存中的数据 展示最新的店铺信息
        Redis::del('shopList');

        $cont=$shop->status==1?$shop->shop_name.'已通过审核':$shop->shop_name.'未通过审核';
        $content=date('Y-m-d H:i:s').$cont;
        $title='商铺通知';
        $user_id=ShopUser::where('shop_id',$shop->id)->first()->user_id;
        $email=User::find($user_id)->email;

//        $this->sendEmail($title,$content,$email);

        $EmailJob=new SendEmail($email,$content,$title);

        $this->dispatch($EmailJob);

        return redirect()->route('shops.index');
    }

    public function sendEmail($title,$content,$email)
    {
        $r =\Illuminate\Support\Facades\Mail::send('Email', ['content'=>$content], function ($message)use($title,$content,$email) {
            $message->from('pingran1993@163.com', 'eleb平台');
            $message->to([$email])->subject($title);
        });
    }
}
