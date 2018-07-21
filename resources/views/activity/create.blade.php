@extends('default')
@section('content')
    @include('default._errors')
    @include('vendor.ueditor.assets')
    <form class="form-horizontal" action="{{route('activities.store')}}" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">活动标题</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" value="{{old('title')}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">活动开始时间</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name="start_time" value="{{old('start_time')}}">
            </div>
        </div>

        {{csrf_field()}}

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">活动结束时间</label>
            <div class="col-sm-10">
                <input class="form-control" type="date" name="end_time">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">活动结束时间</label>
            <div class="col-sm-10">
                <textarea id="container" name="content"  style="height: 300px;"></textarea>
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-block">发布</button>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>

    <!-- 编辑器容器 -->
    <script id="container" name="content" type="text/plain"></script>
@endsection
