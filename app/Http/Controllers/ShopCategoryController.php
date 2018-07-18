<?php

namespace App\Http\Controllers;

use App\Models\ShopCategory;
use Illuminate\Http\Request;

class ShopCategoryController extends Controller
{
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
                'name' => ['required', 'max:5'],
                'img' => ['dimensions:min_width=1,min_height=1'],
            ],
            [
                'name.required' => '分类名字不能为空',
                'name.max' => '分类名字不能超过5个字',
                'img.dimensions' => '请上传图片格式',
            ]
        );


        if ($request->img) {
            $fileName = $request->img->store('public/img');
            $request['img'] = $fileName;
        } else {
            $request['img'] = 'public/img/NIPbVWiP9R62FgWgtazi4UXdFZP8kaVFFpsOMy6j.jpeg';
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
                'name' => ['required', 'max:5'],
                'img' => ['dimensions:min_width=1,min_height=1'],
            ],
            [
                'name.required' => '分类名字不能为空',
                'name.max' => '分类名字不能超过5个字',
                'img.dimensions' => '请上传图片格式',
            ]
        );


        $data=['name'=>$request->name];
        $status=$request->status??0;
        $data['status']=$status;
        if ($request->img) {
            $fileName = $request->img->store('public/img');
            $data['img'] = $fileName;
        }

        $shopcategory->update($data);

        session()->flash('success','添加成功');

        return redirect()->route('shopcategories.index');
    }


    public function destroy(ShopCategory $ShopCategory)
    {

        $ShopCategory->delete();
        echo '删除成功';
    }
}
