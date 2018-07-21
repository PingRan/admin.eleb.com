@extends('default')
@section('content')
  @include('default._errors')
    <form class="form-horizontal" action="{{route('admins.update',['admin'=>$admin])}}" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">管理员账号</label>
            <div class="col-sm-10">
                <input disabled type="text" name="name" value="{{$admin->name}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">email</label>
            <div class="col-sm-10">
                <input type="text" name="email" value="{{$admin->email}}">
            </div>
        </div>

        {{csrf_field()}}

        {{method_field('patch')}}
        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">原密码</label>
            <div class="col-sm-10">
                <input class="form-control" type="password" name="oldpassword">
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">新密码</label>
            <div class="col-sm-10">
                <input  class="form-control" type="password" name="newpassword">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-10">
                <input  class="form-control" type="password" name="newpassword_confirmation">
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-block">修改</button>
            </div>
        </div>
    </form>
@endsection


