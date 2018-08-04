@extends('default')
@section('content')
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>会员id</th>
            <th>会员账号</th>
            <th>会员电话</th>
            <th>注册时间</th>
            <th>操作</th>
        </tr>
        @foreach($members as $member)
            <tr>
                <td>{{$member->id}}</td>
                <td>{{$member->username}}</td>
                <td>{{$member->tel}}</td>
                <td>{{$member->created_at}}</td>

                <td>
                    @can('Edit-Member')
                    <a class="test" href="{{route('members.edit',['member'=>$member->id])}}"><span
                                class="glyphicon glyphicon-edit"></span></a>
                    @endcan
                    @can('Show-MemberInfo')
                    <a class="test" href="{{route('members.show',['member'=>$member])}}"><span
                                class="glyphicon glyphicon-zoom-in"></span></a>
                    @endcan
                    @can('Del-Member')
                    <a id="{{$member->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>
    {{$members->links()}}
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