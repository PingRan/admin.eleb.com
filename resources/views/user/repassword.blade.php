@extends('default')
@section('content')
    <form class="form-horizontal" action="{{route('resetpassword',['user'=>$userinfo])}}" method="post">
        <div class="form-group">
            <label for="inputUserName3" class="col-sm-2 control-label">商家账号</label>
            <div class="col-sm-10">
                <input type="text" disabled class="form-control" id="inputUserName3" placeholder="账号" name="name" value="{{$userinfo->name}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
                <input type="password" name="password" placeholder="请输入密码">
            </div>
        </div>
        {{ csrf_field() }}

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">确认重置</button>
            </div>
        </div>
    </form>
@endsection