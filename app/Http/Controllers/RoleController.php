<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
      $roles=Role::paginate(6);
       //获取角色拥有的权限，存入角色中
      foreach ($roles as &$role){
          $role->permission=$role->permissions;
      }


      return view('role.index',compact('roles'));
    }
     //添加角色
    public function create()
    {
     //要给角色分配权限
      $permissions=Permission::all(['name','id']);

      return view('role.create',compact('permissions'));
    }
    //保存角色
    public function store(Request $request)
    {
        //验证角色信息
        $this->validate($request,
            [
             'name'=>'required|between:2,20|unique:roles',
              'permission'=>'required',
            ],
            [
             'name.required'=>'请填写角色名字',
             'name.between'=>'角色名字在2-20个字',
             'name.unique'=>'角色名字已存在',
             'permission.required'=>'请分配权限',
            ]
        );
        //验证要分配的权限是否存在
        $result=Permission::whereIn('id',$request->permission)->first();

         if($result==null){
             session()->flash('danger','权限不存在');
             return redirect()->route('roles.create');
         }
        $role=Role::create(['name'=>$request->name]);
        $role->givePermissionTo($request->permission);

        session()->flash('success','添加角色成功');
        return redirect()->route('roles.index');
    }
     //修改角色
    public function edit(Role $role)
    {
        $permissions=Permission::all();

        return view('role.edit',compact('role','permissions'));
    }
    //保存修改角色
    public function update(Request $request,Role $role)
    {

        $this->validate($request,
            [
                'name'=>['required','between:2,20',Rule::unique('roles')->ignore($role->id)],
                'permission'=>'required',
            ],
            [
                'name.required'=>'请填写角色名字',
                'name.between'=>'角色名字在2-20个字',
                'name.unique'=>'角色名字已存在',
                'permission.required'=>'请分配权限',
            ]
        );
        $role->update(['name'=>$request->name]);
        //先撤销用户的所有权限
        $role->revokePermissionTo($role->permissions);
        //在添加用户新的权限
        $role->givePermissionTo($request->permission);

        session()->flash('success','修改成功');

        return redirect()->route('roles.index');
    }

    //删除角色
    public function destroy(Role $role)
    {
        $role->delete();
        echo 1;
    }
    //查看角色详情
    public function show(Role $role)
    {
        return view('role.show',compact('role'));
    }
}
