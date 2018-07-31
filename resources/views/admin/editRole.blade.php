@extends('default')
@section('content')
  @include('default._errors')
    <form class="form-horizontal" action="{{route('saveAdminRole',['admin'=>$admin])}}" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">管理员账号</label>
            <div class="col-sm-10">
                <input disabled type="text" name="name" value="{{$admin->name}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">email</label>
            <div class="col-sm-10">
                <input disabled type="text" name="email" value="{{$admin->email}}">
            </div>
        </div>

        {{csrf_field()}}

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">请选择角色</label>
            <div class="col-sm-10">

                    @foreach($roles as $role)
                        <label><input type="checkbox" name="role[]" {{$admin->hasRole($role)?'checked':''}}  value="{{$role->id}}">{{$role->name}}</label>&emsp;
                    @endforeach
            </div>

        </div>



        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-block">修改</button>
            </div>
        </div>
    </form>
@endsection


