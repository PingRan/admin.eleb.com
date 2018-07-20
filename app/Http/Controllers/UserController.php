<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>[],
        ]);
    }

    public function index()
    {
        $users=User::paginate(6);

        return view('user.index',compact('users'));
    }


    public function updatestatus(User $user,Request $request)
    {
        $user->update(['status'=>$request->status]);

        session()->flash('success','操作成功');

        return redirect()->route('users.index');
    }


    public function edit(User $user)
    {
      return view('user.edit',compact('user'));
    }

    public function update(Request $request,User $user)
    {
       $this->validate($request,
           [
               'name'=>['required','max:15',Rule::unique('users')->ignore($user->id)],
               'email'=>['required',Rule::unique('users')->ignore($user->id)],
               'password' => ['required', 'between:6,18', 'confirmed'],
           ],
           [
               'name.required'=>'账号不能为空',
               'name.unique'=>'账号已存在',
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
        $success=['success'=>true];
        if($user->shop_id){

            $success=['success'=>false];
            $res=json_encode($success);
            echo $res;
            return ;

        };

        $user->delete();
        $res=json_encode($success);
        echo $res;
    }

    //重置密码页面

    public function resetpass()
    {
        return view('user.repass');
    }

    public function resetname(Request $request)
    {
        $userinfo=User::where('name',$request->name)->first();
        if(!$userinfo){
            session()->flash('danger','账号不存在');
            return redirect()->route('resetpass');
        }

        return view('user.repassword',compact('userinfo'));

    }

    public function resetpassword(User $user,Request $request)
    {
        $password=bcrypt($request->password);

         $user->update(['password'=>$password]);

        session()->flash('success','重置成功');

        return redirect()->route('users.index');
    }

}
