@extends('default')
@section('content')
    @include('default._errors')
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>id</th>
            <th>商家账号</th>
            <th>商家邮箱</th>
            <th>注册时间</th>
            <th>账号状态</th>
            <th>店铺</th>
            <th>账号审核</th>
            <th>操作</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>
                <td>{{$user->status?'可用':'禁用'}}</td>
                <td>
                    <a class="bg-info btn" href="{{route('addshop',['id'=>$user->id])}}">添加商铺</a>
                    <a class="bg-info btn" href="{{route('showall',['id'=>$user->id])}}">查看商铺</a>
                </td>
                <td>
                    <a class="bg-info btn"  href="{{route('update.status',['user'=>$user])}}">{{$user->status?'禁':'启'}}用</a>
                </td>
                <td><a class="test" href="{{route('users.edit',['user'=>$user->id])}}"><span
                                class="glyphicon glyphicon-edit"></span></a>

                    <a id="{{$user->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{$users->links()}}
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
                success: function (e) {
                    if(e['success']){
                        alert('删除成功');
                    }else{
                        alert('该账号下,有商铺，不能删除')
                    }

                    location.href="";

                }
            });

        })


    </script>
@endsection