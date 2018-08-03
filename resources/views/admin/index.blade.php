@extends('default')
@section('content')
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>管理员id</th>
            <th>管理员账号</th>
            <th>管理员邮箱</th>
            <th>添加时间</th>
            <th>角色</th>
            <th>操作</th>
        </tr>
        @foreach($admins as $admin)
            <tr>
                <td>{{$admin->id}}</td>
                <td>{{$admin->name}}</td>
                <td>{{$admin->email}}</td>
                <td>{{$admin->created_at}}</td>
                <td>@foreach($admin->getRoleNames() as $role)
                        {{$role}}
                     @endforeach
                </td>
                <td>
                    <a class="btn bg-info" href="{{route('editAdminRole',['admin'=>$admin->id])}}">修改管理员角色</a>
                    @if(Auth()->id()===$admin->id)
                    <a class="test" href="{{route('admins.edit',['admin'=>$admin->id])}}"><span
                                class="glyphicon glyphicon-edit"></span></a>
                    @endif
                    <a class="test" href="{{route('admins.show',['admin'=>$admin])}}"><span
                                class="glyphicon glyphicon-zoom-in"></span></a>
                    {{--<a id="{{$admin->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>--}}
                </td>
            </tr>
        @endforeach
    </table>
    {{$admins->links()}}
@endsection

@section('js')
    <script>
        $('.table').on('click', '.delete', function () {

            var url = "admins/" + this.id;

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