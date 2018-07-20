@extends('default')
@section('content')
  @include('default._errors')
    <form class="form-horizontal" action="{{route('admins.store')}}" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">管理员账号</label>
            <div class="col-sm-10">
                <input type="text" name="name" value="{{old('name')}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">email</label>
            <div class="col-sm-10">
                <input type="text" name="email" value="{{old('email')}}">
            </div>
        </div>

        {{csrf_field()}}
        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
                <input type="password" name="password">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-10">
                <input type="password" name="password_confirmation">
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">添加</button>
            </div>
        </div>
    </form>
@endsection


