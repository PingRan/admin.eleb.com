@extends('default')
@section('content')
  @include('default._errors')
    <form class="form-horizontal" action="{{route('users.update',['user'=>$user])}}" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">账号</label>
            <div class="col-sm-10">
                <input type="text" name="name" value="{{$user->name}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">email</label>
            <div class="col-sm-10">
                <input type="text" name="email" value="{{$user->email}}">
            </div>
        </div>

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
            <label for="inputPassword7" class="col-sm-2 control-label">账号状态(选中表示启用)</label>
            <div class="col-sm-10">
                <input type="checkbox" {{$user->status?'checked':''}} name="UserStatus" value="1">
            </div>
        </div>

        {{ csrf_field() }}

         {{method_field('patch')}}

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">发布</button>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script>
        $("#add").click(function(){
            var info=$("#info").css('display');

            if(info=='none'){
                $("#info").css('display','block')
            }else{
                $("#info").css('display','none')
            }
        });
    </script>
@endsection

