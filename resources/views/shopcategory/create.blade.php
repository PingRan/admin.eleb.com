@extends('default')
@section('content')
    @include('default._errors')
    <form class="form-horizontal" action="{{route('shopcategories.store')}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="inputUserName3" class="col-sm-2 control-label">商品分类名字</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputUserName3" placeholder="分类名字" name="name" value="{{old('name')}}">
            </div>
        </div>

        {{--<div class="form-group">--}}
            {{--<label for="inputUserName3" class="col-sm-2 control-label">父级分类</label>--}}
            {{--<div class="col-sm-10">--}}
                {{--<select class="form-control" name="pid">--}}
                    {{--<option value="">请选择</option>--}}
                    {{--<option value="0">顶级分类</option>--}}
                    {{--@foreach($categories as $category)--}}
                    {{--<option {{$category->cate_id==old('pid')?'selected':''}} value="{{$category->cate_id}}">{{$category->cate_name}}</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{ csrf_field() }}
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">分类图片</label>
            <div class="col-sm-10">
                <input type="file" name="img">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword8" class="col-sm-2 control-label">分类状态(选中表示显示)</label>
            <div class="col-sm-10">
                <input type="checkbox" name="status" value="1">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">添加</button>
            </div>
        </div>
    </form>
@endsection