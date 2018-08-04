<?php

namespace App\Http\Controllers;

use App\Models\Nav;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PharIo\Manifest\Url;
use Spatie\Permission\Models\Permission;

class NavController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>[],
        ]);
    }
    //
    public function index()
    {
     $navsList=Nav::paginate(6);

     return view('nav.index',compact('navsList'));
    }
    //菜单添加页面
    public function create()
    {
        //读出所有权限
        $permissions=Permission::all();
        //读出所有菜单
        $navs=Nav::all();
        $navs=$this->getTree($navs,0,0);

        return view('nav.create',compact('permissions','navs'));
    }
    //添加保存
    public function store(Request $request)
    {
        $this->validate($request,
            [
              'name'=>'required|between:2,12|unique:navs',
//              'permission_id'=>'required',
            ],
            [
              'name.required'=>'菜单名字不能为空',
              'name.between'=>'菜单名字在2-12个字之间',
              'name.unique'=>'菜单名字已存在',
              'url.required'=>'请填写url地址',
              'permission_id.required'=>'请选择权限'
            ]
        );
        $request['permission']=$request->permission_id??0;
        $request['url']=$request->url??'';
        Nav::create($request->input());
        session()->flash('success','添加菜单成功');
        return redirect()->route('navs.index');
    }
    //无限极分类
    public function getTree($navs,$pid,$peed)
    {
        static $test=[];//在方法体内，一直存在，只重置一次用static静态属性.
        foreach ($navs as &$nav){
            if($nav->pid==$pid){
              $nav->name=str_repeat('----',$peed).$nav->name;
              $test[]=$nav;
              $this->getTree($navs,$nav->id,$peed+1);
            }
        }
        return $test;
    }

    //修改菜单
    public function edit(Nav $nav)
    {
        $permissions=Permission::all();
        //读出所有菜单
        $allNav=Nav::all();
        return view('nav.edit',compact('nav','allNav','permissions'));
    }
    //保存
    public function update(Request $request,Nav $nav)
    {
        $this->validate($request,
            [
                'name'=>['required','between:2,12',Rule::unique('navs')->ignore($nav->id)],
            ],
            [
                'name.required'=>'菜单名字不能为空',
                'name.between'=>'菜单名字在2-12个字之间',
                'name.unique'=>'菜单名字已存在',
                'url.required'=>'请填写url地址',
                'permission_id.required'=>'请选择权限'
            ]);
        if($nav->id==$request->pid){
            return back()->with('danger','不能修改为自己');
        }
        $url=$request->url??'';
        $permission=$request->permission_id??0;

        $nav->update(['name'=>$request->name,'url'=>$url,'permission_id'=>$permission,'pid'=>$request->pid]);

        session()->flash('success','修改菜单成功');
        return redirect()->route('navs.index');
    }
    //删除
    public function destroy(Nav $nav)
    {
        $child=Nav::where('pid',$nav->id)->first();
        $success=['success'=>true];
        if(!empty($child)){
          $success=['success'=>false];
         return $success;
        }
        $nav->delete();
        return $success;
    }
    //show
    public function show(Nav $nav)
    {
        return view('nav.show',compact('nav'));
    }
}
