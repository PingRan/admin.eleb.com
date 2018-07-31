@extends('default')
@section('content')
    <h2>商家菜品数据统计</h2>

    <form action="{{route('menuCount')}}" method="get">
        每日<input type="date" name="Day" value="{{isset($day)?$day:''}}">
        每月<input type="date" name="Month" style="margin-left: 30px;">
            <input type="submit" class="btn-info btn" value="查看">
        <a href="{{route('menuCount',['code'=>1])}}" class="btn-info btn">总计</a>
    </form>

    <table class="table table-striped table-hover">
        <tr>
            <th>商家名字</th>
            <th>菜品名字</th>
            <th>订单数</th>
        </tr>
        @foreach($Menuorders as $menu)
            <tr>
                <td>{{$menu->shop_name}}</td>
                <td>{{$menu->goods_name}}</td>
                <td>{{$menu->num}}</td>
            </tr>
        @endforeach
    </table>
@endsection

@section('js')

@endsection