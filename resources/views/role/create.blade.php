@extends('default')
@section('content')
  @include('default._errors')
    <form class="form-horizontal" action="{{route('roles.store')}}" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">角色名字</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{old('name')}}">
            </div>
        </div>
         {{csrf_field()}}

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">请选择权限</label>
            <div class="col-sm-10">
                @foreach($permissions as $permission)
                    <label><input type="checkbox" name="permission[]" value="{{$permission->id}}">{{$permission->name}}</label>&emsp;
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
