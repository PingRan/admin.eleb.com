@extends('default')
@section('content')
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>id</th>
            <th>用户</th>
            <th>省</th>
            <th>市</th>
            <th>县</th>
            <th>详细地址</th>
            <th>收货人电话</th>
            <th>收货人姓名</th>
            <th>是否是默认地址</th>
            <th>操作</th>
        </tr>
        @foreach($addresses as $address)
            <tr>
                <td>{{$address->id}}</td>
                <td>{{$address->member_id}}</td>
                <td>{{$address->province}}</td>
                <td>{{$address->city}}</td>
                <td>{{$address->county}}</td>
                <td>{{$address->address}}</td>
                <td>{{$address->tel}}</td>
                <td>{{$address->name}}</td>
                <td>{{$address->is_default}}</td>
                <td>

                    <a class="test" href="{{route('addresses.edit',['address'=>$address->id])}}"><span
                                class="glyphicon glyphicon-edit"></span></a>

                    <a class="test" href="{{route('addresses.show',['address'=>$address])}}"><span
                                class="glyphicon glyphicon-zoom-in"></span></a>
                    <a id="{{$address->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{--{{$admin->links()}}--}}
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