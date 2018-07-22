@extends('default')
@section('content')
    <table class="table table-striped table-hover">
        <tr class="success">
            <th>id</th>
            <th>分类名字</th>
            <th>分类图片</th>
            <th>分类状态</th>
            <th>操作</th>
        </tr>
        @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td><img width="50px;" src="{{$category->img}}"></td>
                <td>{{$category->status?'显示':'隐藏'}}</td>
                <td><a class="test" href="{{route('shopcategories.edit',['shopcategory'=>$category->id])}}"><span class="glyphicon glyphicon-edit"></span></a>
                    <a class="test" href="{{route('shopcategories.show',['shopcategory'=>$category])}}"><span class="glyphicon glyphicon-zoom-in"></span></a>

                    <a id="{{$category->id}}" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>

                </td>
            </tr>
        @endforeach
    </table>
@endsection

@section('js')
    <script>
        $('.table').on('click','.delete',function(){

            var url="shopcategories/"+this.id;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:url,
                type:"DELETE",
                dataType:"json",
                success:function(e){


                    if(e['success']){
                        alert('删除成功');
                    }else{
                        alert('该分类下有店铺，不能删除')
                    }

                    location.href="";


                }
            });

        })


    </script>
@endsection