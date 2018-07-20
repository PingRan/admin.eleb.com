@extends('default')
@section('content')
    @include('default._errors')
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>id</th>
            <th>商家账号</th>
            <th>商家邮箱</th>
            <th>拥有店铺</th>
            <th>注册时间</th>
            <th>账号状态</th>
            <th>状态操作</th>
            <th>操作</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->shop_id}}</td>
                <td>{{$user->created_at}}</td>
                <td>{{$user->status?'可用':'禁用'}}</td>
                <td>
                    @if(!$user->status)
                    <a href="{{route('update.status',['user'=>$user,'status'=>1])}}">启动</a>
                    @else
                        <a href="{{route('update.status',['user'=>$user,'status'=>0])}}">禁用</a>
                    @endif
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