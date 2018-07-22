<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\ShopUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [],
        ]);
    }


    //展示商户信息
    public function index()
    {
        $shops = Shop::paginate(6);

        return view('shop.index', compact('shops'));

    }

    //添加商户信息页面
    public function create()
    {
        $categories = ShopCategory::all();

        return view('shop.create', compact('categories'));
    }

    //商户信息保存
    public function store(Request $request)
    {

        $this->validate($request,
            [
                'name' => 'required|between:6,12|unique:users',
                'email' => 'required|unique:users|email',
                'password' => ['required', 'between:6,18', 'confirmed'],
                'shop_category_id' => ['required'],
                'shop_name' => ['required', 'max:20'],
                'shop_img' => ['required'],
                'start_send' => ['required'],
                'send_cost' => ['required'],
            ], [
                'name.required' => '账号不能为空',
                'name.max' => '账号为6-12个字符',
                'name.unique' => '账号已存在',
                'email.required' => '邮箱不能为空',
                'email.email' => '邮箱格式不对',
                'email.unique' => '邮箱已存在',
                'shop_name.required' => '店铺名字不能为空',
                'shop_name.max' => '店铺名字在20位以内',
                'start_send.required' => '起送金额不能为空',
                'send_cost.required' => '配送金额不能为空',
                'password.required' => '密码必须填写',
                'password.between' => '密码在6-18位',
                'password.confirmed' => '密码和确认密码不一致！',
                'shop_img.required' => '请上传店铺图片'
            ]
        );


        $request['brand'] = $request->brand??0;
        $request['on_time'] = $request->on_time??0;
        $request['fengniao'] = $request->fengniao??0;
        $request['bao'] = $request->bao??0;
        $request['piao'] = $request->piao??0;
        $request['zhun'] = $request->zhun??0;


        $request['shop_rating'] =mt_rand(1,5);

        $request['status'] = $request->ShopStatus;

        $request['password'] = bcrypt($request->password);


        DB::beginTransaction();

        try {

            $shop = Shop::create($request->input());

            $shop_id = $shop->id;//店铺的主键

            $request['shop_id'] = $shop_id;

            $request['status'] = $request->UserStatus??0;

            $user=User::create($request->input());

            $user_id=$user->id;

            ShopUser::create(['shop_id'=>$shop_id,'user_id'=>$user_id]);

            DB::commit();

            session()->flash('success', '添加和注册成功');

        } catch (\Exception $e) {
            dd($e);
            session()->flash('danger', '注册失败');
            DB::rollBack();
        }

        return redirect()->route('shops.index');

    }

    //商户信息修改页面
    public function edit(Shop $shop)
    {
        $categories = ShopCategory::all();

        return view('shop.edit', compact('shop', 'categories'));
    }

    //商户信息修改保存
    public function update(Request $request, Shop $shop)
    {
        $this->validate($request,
            [
                'shop_category_id' => ['required'],
                'shop_name' => ['required', 'max:20'],
//                'shop_img' => ['dimensions:min_width=1,min_height=1'],
                'start_send' => ['required'],
                'send_cost' => ['required'],
            ], [
                'shop_name.required' => '店铺名字不能为空',
                'shop_name.max' => '店铺名字在20位以内',
                'start_send.required' => '起送金额不能为空',
                'send_cost.required' => '配送金额不能为空',
//                'shop_img.dimensions' => '请上传一张图片',
            ]
        );


        $data = ['shop_name' => $request->shop_name, 'shop_category_id' => $request->shop_category_id, 'start_send' => $request->start_send, 'send_cost' => $request->send_cost, 'status' => $request->ShopStatus];


        $data['brand'] = $request->brand??0;
        $data['on_time'] = $request->on_time??0;
        $data['fengniao'] = $request->fengniao??0;
        $data['bao'] = $request->bao??0;
        $data['piao'] = $request->piao??0;
        $data['zhun'] = $request->zhun??0;
        $data['shop_rating'] = mt_rand(1,5);//商店评分要优化

        if ($request->shop_img) {

            $data['shop_img']=$request->shop_img;
        }

        $shop->update($data);

        session()->flash('success', '修改成功');

        return redirect()->route('shops.index');
    }
    //商户删除
    public function destroy(Shop $shop)
    {
        $shop->delete();
        echo '删除成功';
    }

     //商户详情信息
    public function show(Shop $shop)
    {
        return view('shop.show', compact('shop'));
    }
     //指定账户添加商铺  展示列表
    public function addshop(Request $request)
    {
        $user_id=$request->id;
        $categories = ShopCategory::all();

        return view('shop.addshop',compact('user_id','categories'));
    }
     //保存指定商户
    public function saveshop(Request $request)
    {
        if($request->adduser){

            $this->validate($request,
                [
                    'name' => 'required|between:6,12|unique:users',
                    'email' => 'required|unique:users|email',
                    'password' => ['required', 'between:6,18', 'confirmed'],
                    'shop_category_id' => ['required'],
                    'shop_name' => ['required', 'max:20'],
                    'shop_img' => ['required'],
                    'start_send' => ['required'],
                    'send_cost' => ['required'],
                ], [
                    'name.required' => '账号不能为空',
                    'name.max' => '账号为6-12个字符',
                    'name.unique' => '账号已存在',
                    'email.required' => '邮箱不能为空',
                    'email.email' => '邮箱格式不对',
                    'email.unique' => '邮箱已存在',
                    'shop_name.required' => '店铺名字不能为空',
                    'shop_name.max' => '店铺名字在20位以内',
                    'start_send.required' => '起送金额不能为空',
                    'send_cost.required' => '配送金额不能为空',
                    'password.required' => '密码必须填写',
                    'password.between' => '密码在6-18位',
                    'password.confirmed' => '密码和确认密码不一致！',
                    'shop_img.required' => '请上传店铺图片'
                ]
            );


            $request['brand'] = $request->brand??0;
            $request['on_time'] = $request->on_time??0;
            $request['fengniao'] = $request->fengniao??0;
            $request['bao'] = $request->bao??0;
            $request['piao'] = $request->piao??0;
            $request['zhun'] = $request->zhun??0;



            $request['shop_rating'] = mt_rand(1,5);

            $request['status'] = $request->ShopStatus??0;

            $request['password'] = bcrypt($request->password);


            DB::beginTransaction();

            try {

                $shop = Shop::create($request->input());

                $shop_id = $shop->id;//店铺的主键

                $request['shop_id'] = $shop_id;

                $request['status'] = $request->UserStatus??0;

                $user=User::create($request->input());

                $user_id=$user->id;

                ShopUser::create(['shop_id'=>$shop_id,'user_id'=>$user_id]);

                ShopUser::create(['shop_id'=>$shop_id,'user_id'=>$request->id]);

                DB::commit();

                session()->flash('success', '添加和注册成功');

                return redirect()->route('shops.index');

            } catch (\Exception $e) {
                session()->flash('danger', '注册失败');
                DB::rollBack();
            }

        }else{

            $this->validate($request,
                [
                    'shop_category_id' => ['required'],
                    'shop_name' => ['required', 'max:20'],
                    'shop_img' => ['required'],
                    'start_send' => ['required'],
                    'send_cost' => ['required'],
                ],
                [
                    'shop_name.required' => '店铺名字不能为空',
                    'shop_name.max' => '店铺名字在20位以内',
                    'start_send.required' => '起送金额不能为空',
                    'send_cost.required' => '配送金额不能为空',
                    'shop_img.required' => '请上传店铺图片'
                ]
            );


            $request['brand'] = $request->brand??0;
            $request['on_time'] = $request->on_time??0;
            $request['fengniao'] = $request->fengniao??0;
            $request['bao'] = $request->bao??0;
            $request['piao'] = $request->piao??0;
            $request['zhun'] = $request->zhun??0;


            $request['shop_rating'] = mt_rand(1,5);

            $request['status'] = $request->ShopStatus??0;

            try {
                DB::beginTransaction();

                $shop = Shop::create($request->input());

                $shop_id = $shop->id;//店铺的主键

                $user_id=$request->id;

                ShopUser::create(['shop_id'=>$shop_id,'user_id'=>$user_id]);

                DB::commit();

                session()->flash('success', '添加商铺成功');

            } catch (\Exception $e) {
                session()->flash('danger', '注册失败');
                DB::rollBack();
            }


            session()->flash('success','注册成功');

            return redirect()->route('shops.index');

        }


    }

    //查看指定账号下的所有商铺
    public function showall(Request $request)
    {
       $user_id=$request->id;
       $shops= ShopUser::where('user_id',$user_id)->get();//得到所有的店铺id

        $shopall=[];

        foreach ($shops as $shop){
            $shopall[]=$shop->shop_id;
        }

       $datashop=Shop::whereIn('id',$shopall)->get();


       return view('shop.showall',compact('datashop'));
    }
}
