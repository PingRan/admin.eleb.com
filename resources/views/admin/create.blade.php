@extends('default')
@section('content')
  @include('default._errors')
    <form class="form-horizontal" action="{{route('admins.store')}}" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">管理员账号</label>
            <div class="col-sm-10">
                <input type="text"  class="form-control" name="name" value="{{old('name')}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">email</label>
            <div class="col-sm-10">
                <input type="text"  class="form-control" name="email" value="{{old('email')}}">
            </div>
        </div>

        {{csrf_field()}}
        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
                <input  class="form-control" type="password" name="password">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-10">
                <input  class="form-control" type="password" name="password_confirmation">
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">请选择角色</label>
            <div class="col-sm-10">
                @foreach($roles as $role)
                    <label><input type="checkbox" name="role[]" value="{{$role->id}}">{{$role->name}}</label>&emsp;
                @endforeach
            </div>

        </div>





        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-block">添加</button>
            </div>
        </div>
    </form>
@endsection


