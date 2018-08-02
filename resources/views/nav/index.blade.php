@extends('default')
@section('content')
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>菜单id</th>
            <th>菜单名字</th>
            <th>菜单路由</th>
            <th>菜单权限</th>
            <th>操作</th>
        </tr>
        @foreach($navsList as $list)
            <tr>
                <td>{{$list->id}}</td>
                <td>{{$list->name}}</td>
                <td>{{$list->url}}</td>
                <td>{{$list->permission_id}}</td>
                <td>

                    <a class="test" href="{{route('navs.edit',['nav'=>$list->id])}}"><span
                                class="glyphicon glyphicon-edit"></span></a>

                    <a class="test" href="{{route('navs.show',['nav'=>$list])}}"><span
                                class="glyphicon glyphicon-zoom-in"></span></a>
                    <a id="{{$list->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{$navsList->links()}}
@endsection

@section('js')
    <script>
        $('.table').on('click', '.delete', function () {

            var url = "navs/" + this.id;

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
                        alert('该菜单下有子菜单，不能删除')
                    }

                    location.href="";
                }
            });

        })


    </script>
@endsection