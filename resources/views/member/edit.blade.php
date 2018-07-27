@extends('default')
@section('content')
  @include('default._errors')
    <form class="form-horizontal" action="{{route('members.update',['member'=>$member])}}" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">会员账号修改</label>
            <div class="col-sm-10">
                <input type="text"  class="form-control" name="username" value="{{$member->username}}">
            </div>
        </div>

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

        {{csrf_field()}}
        {{method_field('patch')}}
        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">电话</label>
            <div class="col-sm-10">
                <input  class="form-control" type="number" name="tel" value="{{$member->tel}}">
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-block">修改</button>
            </div>
        </div>
    </form>
@endsection


