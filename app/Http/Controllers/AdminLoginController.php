<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{



    public function index()
    {
        if(Auth::check()){
            return redirect()->route('shops.index');
        }

        return view('adminlogin.index');
    }

    public function check(Request $request)
    {

        $this->validate($request,
            [
                'name' => ['required'],
                'password' => ['required'],
                'captcha' => ['required', 'captcha'],
            ],
            [
                'name.required' => '请填写账号',
                'password.required' => '请填写密码',
                'captcha.required' => '验证码不能为空',
                'captcha.captcha' => '验证码出错',
            ]
        );

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password],$request->remberme)) {

            session()->flash('success','登录成功');

            return redirect()->route('admins.index');
        } else {

            session()->flash('danger','账号或者密码错误');

            return back()->withInput();
        }
    }

    public function loginout()
    {
       Auth::logout();

       session()->flash('success','注销成功');

       return redirect()->route('adminlogin');
    }
}
