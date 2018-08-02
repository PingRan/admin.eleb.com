@extends('default')
@section('content')

    <table class="table table-striped table-hover">
        <tr class="success">
            <th>活动id</th>
            <th>活动标题</th>
            <th>活动开始时间</th>
            <th>活动结束时间</th>
            <th>活动开奖日期</th>
            <th>活动报名人数上限</th>
            <th>活动是否开奖</th>
            <th>操作</th>
        </tr>
        @foreach($events as $event)
            <tr>
                <td>{{$event->id}}</td>
                <td>{{$event->title}}</td>
                <td>{{date('Y-m-d',$event->signup_start)}}</td>
                <td>{{date('Y-m-d',$event->signup_end)}}</td>
                <td>{{$event->prize_date}}</td>
                <td>{{$event->signup_num}}</td>
                <td>{{$event->is_prize?'已开奖':'未开奖'}}</td>
                <td>

                    <a class="test" href="{{route('events.edit',['event'=>$event->id])}}"><span
                                class="glyphicon glyphicon-edit"></span></a>

                    <a class="test" href="{{route('events.show',['event'=>$event])}}"><span
                                class="glyphicon glyphicon-zoom-in"></span></a>


                    <a id="{{$event->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>

                    <a  class="btn bg-info" href="{{route('startLottery',['event'=>$event])}}">开奖</a>

                </td>

            </tr>
        @endforeach
    </table>
    {{--{{$activities->links()}}--}}
@endsection

@section('js')
    <script>
        $('.table').on('click', '.delete', function () {

            var url = "events/" + this.id;

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