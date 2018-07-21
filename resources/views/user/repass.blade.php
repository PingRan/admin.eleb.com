@extends('default')
@section('content')
    <form class="form-horizontal" action="{{route('resetname')}}" method="get">
        <div class="form-group">
            <label for="inputUserName3" class="col-sm-2 control-label">商家账号</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputUserName3" placeholder="账号" name="name" value="{{old('name')}}">
            </div>
        </div>
        {{ csrf_field() }}

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-block">搜索</button>
            </div>
        </div>
    </form>
@endsection