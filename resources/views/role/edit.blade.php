@extends('default')
@section('content')
  @include('default._errors')
    <form class="form-horizontal" action="{{route('roles.update',['role'=>$role])}}" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">角色名字</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{$role->name}}">
            </div>
        </div>
         {{csrf_field()}}
         {{method_field('patch')}}
        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">请选择权限</label>
            <div class="col-sm-10">

                @foreach($permissions as $permission)
                    <label><input type="checkbox" {{$role->hasPermissionTo($permission)?'checked':''}}  name="permission[]" value="{{$permission->id}}">{{$permission->name}}</label>&emsp;
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
