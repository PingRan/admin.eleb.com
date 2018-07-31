@extends('default')
@section('content')
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>角色id</th>
            <th>角色名字</th>
            <th>角色拥有的权限</th>
            <th>角色创建时间</th>
            <th>操作</th>
        </tr>
        @foreach($roles as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td>{{$role->name}}</td>
                <td>
                    @foreach($role->permission as $per)
                        {{$per->name}}&emsp;
                    @endforeach
                </td>
                <td>{{$role->created_at}}</td>
                <td><a class="test" href="{{route('roles.edit',['role'=>$role->id])}}"><span
                                class="glyphicon glyphicon-edit"></span></a>
                    <a class="test" href="{{route('roles.show',['role'=>$role])}}"><span
                                class="glyphicon glyphicon-zoom-in"></span></a>
                    <a id="{{$role->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{$roles->links()}}
@endsection

@section('js')
    <script>
        $('.table').on('click', '.delete', function () {

            var url = "roles/" + this.id;

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