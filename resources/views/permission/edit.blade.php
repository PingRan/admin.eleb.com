@extends('default')
@section('content')
  @include('default._errors')
     <h3>修改权限</h3>
    <form class="form-horizontal" action="{{route('permissions.update',['permission'=>$permission])}}" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">权限名字</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{$permission->name}}">
            </div>
        </div>
         {{csrf_field()}}
         {{method_field('patch')}}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-block">修改</button>
            </div>
        </div>
    </form>
@endsection
