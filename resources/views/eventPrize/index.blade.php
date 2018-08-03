@extends('default')
@section('content')
    <h1>设置奖品</h1>

    <table class="table table-striped table-hover">
        <tr class="success">
            <th>奖品id</th>
            <th>奖品名称</th>
            <th>奖品所属活动</th>
            <th>奖品数量</th>
            <th>操作</th>
        </tr>
        @foreach($eventPrizes as $prize)
            <tr>
                <td>{{$prize->id}}</td>
                <td>{{$prize->name}}</td>
                <td>{{$prize->eventName->title}}</td>
                <td>{{$prize->num}}</td>
                <td>
                    <a class="test" href="{{route('eventPrizes.edit',['eventPrize'=>$prize->id])}}"><span
                                class="glyphicon glyphicon-edit"></span></a>

                    <a class="test" href="{{route('eventPrizes.show',['eventPrize'=>$prize])}}"><span
                                class="glyphicon glyphicon-zoom-in"></span></a>

                    <a id="{{$prize->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>

                </td>

            </tr>
        @endforeach
    </table>
    {{$eventPrizes->links()}}
@endsection

@section('js')
    <script>
        $('.table').on('click', '.delete', function () {

            var url = "eventPrizes/" + this.id;

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
                    if(e['success']){
                        alert('删除成功');
                    }else{
                        alert('活动已经开奖，不能删除该奖品')
                    }

                    location.href = "";
                }
            });

        })


    </script>
@endsection