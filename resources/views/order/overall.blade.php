@extends('default')
@section('content')
    <h1>平台整体菜品销量统计</h1>
    <form action="{{route('overall')}}" method="get">
        每日<input type="date" name="Day" style="margin-left: 30px;" value="{{isset($day)?$day:''}}">
        每月<input type="date" name="Month" style="margin-left: 30px;">
            <input type="submit" class="btn-info btn" value="查看">
        <a href="{{route('overall',['code'=>1])}}" class="btn-info btn">总计</a>
    </form>

    <table class="table table-striped table-hover">
        <tr>

            <th>菜品名字</th>
            <th>菜品销量</th>
            <th>所属商家</th>
        </tr>
        @foreach($overalls as $overall)
            <tr>

                <td>{{$overall->goods_name}}</td>
                <td>{{$overall->num}}</td>
                <td>{{$overall->shop_name}}</td>
            </tr>
        @endforeach
    </table>
@endsection

@section('js')

@endsection