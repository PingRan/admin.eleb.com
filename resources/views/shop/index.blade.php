@extends('default')
@section('content')
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>商家编号</th>
            <th>商家名字</th>
            {{--<th>商家账号</th>--}}
            <th>商家分类</th>
            <th>添加时间</th>
            <th>商家状态</th>
            <th>操作</th>
        </tr>
        @foreach($shops as $shop)
            <tr>
                <td>{{$shop->id}}</td>
                <td>{{$shop->shop_name}}</td>
                <td>{{$shop->shop_category->name}}</td>
                <td>{{$shop->created_at}}</td>
                <td>{{$shop->status?($shop->status==1?'正常':'禁用'):'待审核'}}</td>

                <td>
                    @can('Edit-ShopInfo')
                    <a class="test" href="{{route('shops.edit',['shop'=>$shop->id])}}"><span
                                class="glyphicon glyphicon-edit"></span></a>
                     @endcan
                    @can('Show-ShopInfo')
                    <a class="test" href="{{route('shops.show',['shop'=>$shop])}}"><span
                                class="glyphicon glyphicon-zoom-in"></span></a>
                    @endcan
                    @can('Del-ShopInfo')
                    <a id="{{$shop->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>
    {{$shops->links()}}
@endsection

@section('js')
    <script>
        $('.table').on('click', '.delete', function () {

            var url = "shops/" + this.id;

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