<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>[],
        ]);
    }
    //权限列表
    public function index()
    {
      $permissions=Permission::paginate(6);
      return view('permission.index',compact('permissions'));
    }
    //添加权限表单
    public function create()
    {
        return view('permission.create');
    }
    //保存权限
    public function store(Request $request)
    {
       //验证权限名是否合法
        $this->validate($request,
            [
              'name'=>'required|between:2,20|unique:permissions',
            ],
            [
                'name.required'=>'请填写权限名字',
                'name.between'=>'权限名字在2-10个字',
                'name.unique'=>'权限名字已经存在'
            ]
        );

        Permission::create(['name'=>$request->name]);

        session()->flash('success','添加权限成功');

        return redirect()->route('permissions.index');
    }
    //修改权限
    public function edit(Permission $permission)
    {
        return view('permission.edit',compact('permission'));
    }
    //保存修改权限
    public function update(Request $request,Permission $permission)
    {
        $this->validate($request,
            [
                'name'=>['required','between:2,20',Rule::unique('permissions')->ignore($permission->id)],
            ],
            [
                'name.required'=>'请填写权限名字',
                'name.between'=>'权限名字在2-10个字',
                'name.unique'=>'权限名字已经存在'
            ]
        );

        $permission->update(['name'=>$request->name]);

        session()->flash('success','修改权限成功');

        return redirect()->route('permissions.index');
    }
    //删除权限
    public function destroy(Permission $permission)
    {
        //如果权限已经被角色使用。要先取消在删除

        $permission->delete();
        echo 1;
    }



}
