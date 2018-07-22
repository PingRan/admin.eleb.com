<?php

namespace App\Http\Controllers;

use App\Models\ShopCategory;
use Illuminate\Http\Request;

class ShopCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>[],
        ]);
    }


    public function index()
    {

        $categories = ShopCategory::all();

        return view('shopcategory.index', compact('categories'));
    }

    public function create()
    {
        return view('shopcategory.create');
    }


    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => ['required', 'max:10'],
//                'img' => ['required'],
            ],
            [
                'name.required' => '分类名字不能为空',
                'name.max' => '分类名字不能超过10个字',
//                'img.dimensions' => '请上传图片格式',
            ]
        );


        if ($request->img) {

            $request['img']=$request->img;

        } else {
            $request['img'] = 'http://elebran.oss-cn-shenzhen.aliyuncs.com/elebran/upload/08OKM34Y9GdYt5rEdvBLnJS0OQn3s4MBMvfIsoCk.jpeg';
        }

        ShopCategory::create($request->input());

        session()->flash('success','添加成功');

        return redirect()->route('shopcategories.index');
    }


    public function edit(ShopCategory $shopcategory)
    {

        return view('shopcategory.edit',compact('shopcategory'));
    }

    public function update(Request $request,ShopCategory $shopcategory)
    {
        $this->validate($request,
            [
                'name' => ['required', 'max:10'],
//                'img' => ['dimensions:min_width=1,min_height=1'],
            ],
            [
                'name.required' => '分类名字不能为空',
                'name.max' => '分类名字不能超过10个字',
//                'img.dimensions' => '请上传图片格式',
            ]
        );


        $data=['name'=>$request->name];
        $status=$request->status??0;
        $data['status']=$status;
        if ($request->img) {

            $data['img']=$request->img;
        }

        $shopcategory->update($data);

        session()->flash('success','添加成功');

        return redirect()->route('shopcategories.index');
    }


    public function destroy(ShopCategory $shopcategory)
    {



        $id=$shopcategory->id;

        $a=ShopCategory::where('id',$id)->withCount('shops')->first();

        $shops=$a->shops_count;

        $success=['success'=>true];

        if($shops>0){
            $success=['success'=>false];
            $res=json_encode($success);
            echo $res;
            return ;
        }

        $shopcategory->delete();
        $res=json_encode($success);
        echo $res;

    }
}
