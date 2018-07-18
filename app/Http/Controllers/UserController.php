<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $users=User::all();

        return view('user.index',compact('users'));
    }

    public function create()
    {

    }

    public function edit(User $user)
    {
      return view('user.edit',compact('user'));
    }

    public function update(Request $request,User $user)
    {
       $this->validate($request,
           [
               'name'=>'required|max:15',
               'email'=>'required|email',
               'password' => ['required', 'between:6,18', 'confirmed'],
           ],
           [
               'name.required'=>'账号不能为空',
               'name.max'=>'账号不能超过15',
               'email.required'=>'邮箱不能为空',
               'password.required'=>'密码必填',
               'password.between'=>'密码在6-18位',
               'password.confirmed' => '密码和确认密码不一致！',
           ]
       );

       $data=['name'=>$request->name,'email'=>$request->email];
       $data['status']=$request->status??0;
       $data['shop_id']=1;
       $data['password']=bcrypt($request->password);
       $user->update($data);

       session()->flash('success','修改成功');
       return redirect()->route('users.index');
    }


    public function destroy(User $user)
    {
        $user->delete();
        echo '删除成功';
    }
}
