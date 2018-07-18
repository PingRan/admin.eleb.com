@extends('default')
@section('content')
    @include('default._errors')
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>id</th>
            <th>商家账号</th>
            <th>商家邮箱</th>
            <th>账号状态</th>
            <th>拥有店铺</th>
            <th>注册时间</th>
            <th>操作</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->status?'可用':'禁用'}}</td>
                <td>{{$user->shop_id}}</td>
                <td>{{$user->created_at}}</td>
                <td><a class="test" href="{{route('users.edit',['user'=>$user->id])}}"><span
                                class="glyphicon glyphicon-edit"></span></a>
                    {{--<a class="test" href="{{route('users.show',['user'=>$user])}}"><span--}}
                                {{--class="glyphicon glyphicon-zoom-in"></span></a>--}}

                    <a id="{{$user->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection

@section('js')
    <script>
        $('.table').on('click', '.delete', function () {

            var url = "users/" + this.id;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                type: "DELETE",
                dataType: "json",
                error: function (e) {

                    location.href = "";
                }
            });

        })


    </script>
@endsection