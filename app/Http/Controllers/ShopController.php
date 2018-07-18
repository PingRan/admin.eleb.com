<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    //展示商户信息
    public function index()
    {
        $shops=Shop::all();

        return view('shop.index',compact('shops'));

    }
     //添加商户信息页面
    public function create()
    {
      $categories=ShopCategory::all();

     return view('shop.create',compact('categories'));
    }

    //商户信息保存
    public function store(Request $request)
    {

        if($request->addshop){

            $this->validate($request,
                [
                    'name'=>'required|max:15|unique:users',
                    'email'=>'required|unique:users|email',
                    'password' => ['required', 'between:6,18', 'confirmed'],
                    'shop_category_id'=>['required'],
                    'shop_name'=>['required','max:20'],
                    'shop_img'=>['required','dimensions:min_width=1,min_height=1'],
                    'start_send'=>['required'],
                    'send_cost'=>['required'],
                ],[
                    'name.required'=>'账号不能为空',
                    'name.max'=>'账号不能超过15个字符',
                    'name.unique'=>'账号已存在',
                    'email.required'=>'邮箱不能为空',
                    'email.email'=>'邮箱格式不对',
                    'email.unique'=>'邮箱已存在',
                    'shop_name.required'=>'店铺名字不能为空',
                    'shop_name.max'=>'店铺名字在20位以内',
                    'start_send.required'=>'起送金额不能为空',
                    'send_cost.required'=>'配送金额不能为空',
                    'password.required'=>'密码必须填写',
                    'password.between'=>'密码在6-18位',
                    'password.confirmed' => '密码和确认密码不一致！',
                    'shop_img.dimensions' => '请上传一张图片',
                    'shop_img.required' => '请上传店铺图片'
                ]
            );


            $request['brand']=$request->brand??0;
            $request['on_time']=$request->on_time??0;
            $request['fengniao']=$request->fengniao??0;
            $request['bao']=$request->bao??0;
            $request['piao']=$request->piao??0;
            $request['zhun']=$request->zhun??0;

            $fileName = $request->shop_img->store('public/shop_img');

            $request['shop_img'] = $fileName;

            $request['shop_rating'] = 5;

            $request['status']=$request->ShopStatus;


            $shop=Shop::create($request->input());

            $shop_id=$shop->id;

            $request['password']=bcrypt($request->password);

           $request['shop_id']=$shop_id;

           $request['status']=$request->UserStatus??0;


            User::create($request->input());


            session()->flash('success','添加和注册成功');

           return redirect()->route('shops.index');


        }else{

            $this->validate($request,
                [
                    'name'=>'required|max:15|unique:users',
                    'email'=>'required|unique:users|email',
                    'password' => ['required', 'between:6,18', 'confirmed'],
                ],
                [
                    'name.required'=>'账号不能为空',
                    'name.max'=>'账号不能超过15个字符',
                    'name.unique'=>'账号已存在',
                    'password.required'=>'密码必须填写',
                    'password.between'=>'密码在6-18位',
                    'email.required'=>'邮箱不能为空',
                    'email.email'=>'邮箱格式不对',
                    'email.unique'=>'邮箱已存在',
                    'password.confirmed' => '密码和确认密码不一致！',
                ]
            );
            $request['password']=bcrypt($request->password);
            $request['shop_id']=0;
            $request['status']=$request->UserStatus??0;

            User::create($request->input());

            session()->flash('success','注册成功');

           return redirect()->route('shops.index');

        }




    }

    //商户信息修改页面
    public function edit(Shop $shop)
    {
        $categories=ShopCategory::all();

       return view('shop.edit',compact('shop','categories'));
    }

    //商户信息修改保存
    public function update(Request $request,Shop $shop)
    {
        $this->validate($request,
            [
                'shop_category_id'=>['required'],
                'shop_name'=>['required','max:20'],
                'shop_img'=>['dimensions:min_width=1,min_height=1'],
                'start_send'=>['required'],
                'send_cost'=>['required'],
            ],[
                'shop_name.required'=>'店铺名字不能为空',
                'shop_name.max'=>'店铺名字在20位以内',
                'start_send.required'=>'起送金额不能为空',
                'send_cost.required'=>'配送金额不能为空',
                'shop_img.dimensions' => '请上传一张图片',
            ]
        );


        $data=['shop_name'=>$request->shop_name,'shop_category_id'=>$request->shop_category_id,'start_send'=>$request->start_send,'send_cost'=>$request->send_cost];


        $data['brand']=$request->brand??0;
        $data['on_time']=$request->on_time??0;
        $data['fengniao']=$request->fengniao??0;
        $data['bao']=$request->bao??0;
        $data['piao']=$request->piao??0;
        $data['zhun']=$request->zhun??0;
        $data['status']=$request->ShopStatus;
        $data['shop_rating'] = 5;//商店评分要优化

        if($request->shop_img){

            $fileName = $request->shop_img->store('public/shop_img');
            $data['shop_img'] = $fileName;
        }


        $shop->update($data);

        session()->flash('success','修改成功');

        return redirect()->route('shops.index');
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();
        echo '删除成功';
    }
}
