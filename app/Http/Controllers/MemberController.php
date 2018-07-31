<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    //
    public function index()
    {
     $members=Member::paginate(6);

     return view('member.index',compact('members'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'username'=>'required|between:6,12|unique:members',
                'password'=>'required|between:6,18',
//                'tel'=>['required',new Tel()],
            ],
            [
                'username.required'=>'请填写用户名',
                'username.between'=>'用户名在6-12位之间',
                'username.unique'=>'用户名已存在',
                'password.required'=>'密码必须填',
                'password.between'=>'密码在6-18位',
                'tel.required'=>'电话号码必填',
                'tel.numeric'=>'电话号码必须是数字',
                'tel.unique'=>'电话号码已被注册'
            ]
        );
        $request['password']=bcrypt($request->password);

        Member::create($request->input());

        session()->flash('success','注册成功');

        return redirect()->route('members.index');
    }

    public function edit(Member $member)
    {
        return view('member.edit',compact('member'));
    }

    public function update(Request $request,Member $member)
    {

        $this->validate($request,
            [
                'username'=>['required',Rule::unique('members')->ignore($member->id)],
                'password'=>'required|between:6,18',
//                'tel'=>['required',new Tel()],
            ],
            [
                'username.required'=>'请填写用户名',
                'username.between'=>'用户名在6-12位之间',
                'username.unique'=>'用户名已存在',
                'password.required'=>'密码必须填',
                'password.between'=>'密码在6-18位',
                'tel.required'=>'电话号码必填',
                'tel.numeric'=>'电话号码必须是数字',
                'tel.unique'=>'电话号码已被注册'
            ]
        );

        $password=bcrypt($request->password);

        $member->update(['username'=>$request->username,'password'=>$password,'tel'=>$request->tel]);

        session()->flash('success','修改成功');

        return redirect()->route('members.index');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        echo 1;
    }

    public function show(Member $member)
    {
        return view('member.show',compact('member'));
    }
    //修改会员状态
    public function editstatus(Request $request,Member $member)
    {

        $member->update(['status'=>$request->status]);

        session()->flash('success','操作成功');

        return redirect()->route('members.index');
    }
}
