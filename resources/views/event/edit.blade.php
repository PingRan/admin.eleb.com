@extends('default')
@section('content')
    @include('default._errors')
    @include('vendor.ueditor.assets')
    <form class="form-horizontal" action="{{route('events.update',['event'=>$event])}}" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">抽奖活动</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" value="{{$event->title}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">活动报名开始时间</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" name="signup_start" value="{{date('Y-m-d\TH:i:s',$event->signup_start)}}">
            </div>
        </div>

        {{csrf_field()}}
        {{method_field('patch')}}
        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">活动报名结束时间</label>
            <div class="col-sm-10">
                <input class="form-control" type="datetime-local" name="signup_end" value="{{date('Y-m-d\TH:i:s',$event->signup_end)}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">活动开奖时间</label>
            <div class="col-sm-10">
                <input class="form-control" type="date" name="prize_date" value="{{$event->prize_date}}">
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">活动报名人数</label>
            <div class="col-sm-10">
                <input class="form-control" type="number" name="signup_num" value="{{$event->signup_num}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">活动内容</label>
            <div class="col-sm-10">
                <script id="container" name="content" type="text/plain">{!! $event->content !!}</script>
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-block">修改</button>
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

@endsection
