@extends('default')
@section('content')
    @include('default._errors')
    @include('vendor.ueditor.assets')
    <form class="form-horizontal" action="{{route('eventPrizes.update',['eventPrize'=>$eventPrize])}}" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">奖品名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{$eventPrize->name}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">奖品数量</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name="num" value="{{$eventPrize->num}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">所选活动</label>
            <div class="col-sm-10">
                <select name="events_id" id="">
                    <option value="0">请选择活动</option>
                    @foreach($events as $event)
                    <option  {{$eventPrize->events_id==$event->id?'selected':''}} value="{{$event->id}}">{{$event->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">奖品等级</label>
            <div class="col-sm-10">
                <select name="random" id="">
                    <option value="0">奖品等级</option>
                    @foreach($Probabilities as $probability)
                        <option value="{{$probability->id}}">{{$probability->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        {{csrf_field()}}

        {{method_field('patch')}}
        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">奖品详情</label>
            <div class="col-sm-10">
                <script id="container" name="description" type="text/plain">{!!$eventPrize->description!!}</script>
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
