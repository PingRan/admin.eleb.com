@extends('default')
@section('content')
    <a href="{{route('activities.index',['code'=>2])}}" class="btn btn-default">未开始</a>
    <a href="{{route('activities.index',['code'=>1])}}" class="btn btn-default">进行中</a>
    <a href="{{route('activities.index',['code'=>-1])}}" class="btn btn-default">已结束</a>
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>活动id</th>
            <th>活动标题</th>
            <th>活动开始时间</th>
            <th>活动结束时间</th>
            <th>操作</th>
        </tr>
        @foreach($activities as $activity)
            <tr>
                <td>{{$activity->id}}</td>
                <td>{{$activity->title}}</td>
                <td>{{date('Y-m-d',$activity->start_time)}}</td>
                <td>{{date('Y-m-d',$activity->end_time)}}</td>
                <td><a class="test" href="{{route('activities.edit',['activity'=>$activity->id])}}"><span
                                class="glyphicon glyphicon-edit"></span></a>
                    <a class="test" href="{{route('activities.show',['activity'=>$activity])}}"><span
                                class="glyphicon glyphicon-zoom-in"></span></a>
                    <a id="{{$activity->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{$activities->links()}}
@endsection

@section('js')
    <script>
        $('.table').on('click', '.delete', function () {

            var url = "activities/" + this.id;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                type: "DELETE",
                dataType: "json",
                success: function (e) {
                    location.href = "";
                }
            });

        })


    </script>
@endsection