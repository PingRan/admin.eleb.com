@extends('default')
@section('content')
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>活动id</th>
            <th>活动名字</th>
            <th>商家账号</th>
            <th>报名时间</th>
            <th>操作</th>
        </tr>
        @foreach($eventUsers as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->eventName->title}}</td>
                <td>{{$user->user->name}}</td>
                <td>{{$user->created_at}}</td>
                <td>查看</td>
            </tr>
        @endforeach
    </table>
    {{--{{$members->links()}}--}}
@endsection

@section('js')
    <script>
        $('.table').on('click', '.delete', function () {

            var url = "members/" + this.id;

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