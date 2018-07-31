@extends('default')

@section('day')
    <h3 style="margin-top: 25px;">每日订单统计图</h3>
    <form action="" method="get">
        <input class="DayOrder" type="date" name="day">
        <input type="button" class="orderCount btn bg-info" value="查看">
    </form>
@endsection

@section('month')
    <h3 style="margin-top: 25px;">每月订单统计图</h3>
    <form action="" method="get">
        <input class="DayOrder" type="month" name="month">
        <input type="button" class="monthCount btn bg-info" value="查看">
    </form>
@endsection

@section('count')
    <h3 style="margin-top: 25px;">订单总计统计图</h3>
    <form action="" method="get">
        <input  type="hidden" name="code" value="1">
        <input type="button" class="count btn bg-info" value="查看">
    </form>
@endsection
@section('content')
    <h2>订单数据统计</h2>

    <div id="main" style="width: 800px;height:400px;"></div>

@endsection

@section('menuDay')
    <h3 style="margin-top: 25px;">每日菜品统计图</h3>
    <form action="" method="get">
        <input class="menu"  type="date" name="day">
        <input type="button" class="menuDay btn bg-info" value="查看">
    </form>
@endsection

@section('menuMonth')
    <h3 style="margin-top: 25px;">每月菜品统计图</h3>
    <form action="" method="get">
        <input  class="menu" type="month" name="month">
        <input type="button" class="menuMonth btn bg-info" value="查看">
    </form>
@endsection

@section('menuCount')
    <h3 style="margin-top: 25px;">总计菜品统计图</h3>
    <form action="" method="get">
        <input  type="hidden" name="code" value="1">
        <input type="button" class="menuCount btn bg-info" value="查看">
    </form>
@endsection
@section('menu')
    <h2>菜品数据统计</h2>

    <div id="menu" style="width: 800px;height:400px;"></div>

@endsection


@section('js')
    <script type="text/javascript" src="/js/echarts.min.js"></script>
    <script>
      $(".orderCount").click(function(){
       var data=$(this).closest('form').serialize();
          getOrderCount(data);
      });

      $(".monthCount").click(function(){
          var data=$(this).closest('form').serialize();
          getOrderCount(data);
      });

      $(".count").click(function(){
          var data=$(this).closest('form').serialize();
          getOrderCount(data);
      });

    function getOrderCount(data){
        var url="{{route('orderCount')}}";

        $.get(url,data,function(res){
            var orderCount=JSON.parse(res);
            $(".DayOrder").val(orderCount.time);
            var myChart = echarts.init(document.getElementById('main'));
            option = {
                title: {
                    text: '商家订单统计',
                    subtext: '数据来自eleb平台'
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    data: ['2011年', '2012年']
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type: 'value',
                    boundaryGap: [0, 0.01]
                },
                yAxis: {
                    type: 'category',
                    data: orderCount.shop_name
                },
                series: [
                    {
                        name: '订单数',
                        type: 'bar',
                        data: orderCount.count
                    }
                ]
            };
            myChart.setOption(option);

        });
    }

      getOrderCount();


      $(".menuDay").click(function(){
          var data=$(this).closest('form').serialize();

          getMenuCount(data)
      });

      $(".menuMonth").click(function(){
          var data=$(this).closest('form').serialize();

          getMenuCount(data)
      });

      $(".menuCount").click(function(){
          var data=$(this).closest('form').serialize();

          getMenuCount(data)
      });

    function getMenuCount(data){
          var url="{{route('menuCount')}}";

          $.get(url,data,function(res){
             var menuCount=JSON.parse(res);
             $(".menu").val(menuCount.time);
              var myChart = echarts.init(document.getElementById('menu'));
              option = {
                  title: {
                      text: '商家菜品统计',
                      subtext: '数据来自eleb平台'
                  },
                  tooltip: {
                      trigger: 'axis',
                      axisPointer: {
                          type: 'shadow'
                      }
                  },
                  legend: {
                      data: ['2011年', '2012年']
                  },
                  grid: {
                      left: '3%',
                      right: '4%',
                      bottom: '3%',
                      containLabel: true
                  },
                  xAxis: {
                      type: 'value',
                      boundaryGap: [0, 0.01]
                  },
                  yAxis: {
                      type: 'category',
                      data: menuCount.goods_name
                  },
                  series: [
                      {
                          name: '菜品销量',
                          type: 'bar',
                          data: menuCount.count
                      }
                  ]
              };
              myChart.setOption(option);

          });
      }
      getMenuCount();


    </script>

@endsection