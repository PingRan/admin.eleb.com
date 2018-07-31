<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>[],
        ]);
    }

    //显示管理员账号列表
    public function index()
    {
        $admins=Admin::paginate(6);

        return view('admin.index',compact('admins'));
     }

    public function create()
    {
        $roles=Role::all();

        return view('admin.create',compact('roles'));
     }


    public function store(Request $request)
    {
        $this->validate($request,
            [
             'name'=>['required','between:6,12','unique:admins'],
             'email'=>['required','email','unique:admins'],
             'password' => ['required', 'between:6,18', 'confirmed'],
              'role'=>'required',
            ],
            [
                'name.required' => '账号不能为空',
                'name.between' => '账号在6-12个字符',
                'name.unique' => '账号已存在',
                'email.required' => '邮箱不能为空',
                'email.email' => '邮箱格式不对',
                'email.unique' => '邮箱已存在',
                'password.confirmed' => '密码和确认密码不一致',
                'password.required' => '密码必须填写',
                'password.between' => '密码在6-18位',
                'role.required'=>'请选择角色',
            ]
        );

        $request['power']=0;

        $request['password']=bcrypt($request->password);
        $admin=Admin::create($request->input());

        $admin->assignRole($request->role);

        session()->flash('success','添加成功');

        return redirect()->route('admins.index');

     }


    public function edit(Admin $admin)
    {
        return view('admin.edit',compact('admin'));
    }


    public function update(Request $request,Admin $admin)
    {

        $this->validate($request,
            [
                'oldpassword'=>['required'],
                'newpassword' => ['required', 'between:6,18', 'confirmed'],
                'email'=>['required',Rule::unique('admins')->ignore($admin->id)]
            ],
            [
                'email.required' => '邮箱不能为空',
                'email.email' => '邮箱格式不对',
                'email.unique' => '邮箱已存在',
                'oldpassword.required'=>'请填写旧密码',
                'newpassword.confirmed' => '新密码和确认密码不一致',
                'newpassword.required' => '新密码必须填写',
                'newpassword.between' => '新密码在6-18位',
            ]
        );

           $oldpassword=$admin->password;

           $result=Hash::check($request->oldpassword,$oldpassword);

           if($result){

               if(Hash::check($request->newpassword,$oldpassword)){
                   session()->flash('danger','新密码与旧密码一致');
                   return back()->withInput();
               }

               $newpassword=bcrypt($request->newpassword);

               $admin->update(['password'=>$newpassword,'email'=>$request->email]);

               session()->flash('success','修改成功,请重新登录');
               Auth::logout();
               return redirect()->route('login');

           }else{
               session()->flash('danger','旧密码错误');
               return back()->withInput();
           }

     }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        echo '删除成功';
     }

    public function show(Admin $admin)
    {
      return view('admin.show',compact('admin'));
     }
     //修改管理员角色
    public function editAdminRole(Admin $admin)
    {
        $this->authorize('update',$admin);

        $roles=Role::all();//获取所有角色

        return view('admin.editRole',compact('admin','roles'));
    }

    public function saveAdminRole(Request $request,Admin $admin)
    {
        $this->validate($request,
            [
                'role'=>'required',
            ],
            [
                'role.required'=>'请分配角色',
            ]
        );
        $admin->syncRoles($request->role);

        session()->flash('success','修改角色成功');
        return redirect()->route('admins.index');

    }
    
}
