<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{   //订单页面
    public function index()
    {
        return view('order.index');
    }

    public function orderCount(Request $request)
    {
        //定一个一个空数组；返回json结果；
        $orders=[];
        //订单量统计[按商家分别统计和整体统计]（每日、每月、总计）;
        $current_time=$request->day??date('Y-m-d');
        //将时间搜索条件存入数组中回显.
        $orders['time']=$current_time;
        //拼接搜索条件
        $current=$current_time.'%';
        //判断是否是按月份查看  如果时间月份同时存在 取月份的搜索条件。
        $month=$request->month;
        if($month){
            $current=$month.'%';
            //将月份的搜索条件存入数组 传回回显.
            $orders['time']=$month;
        }

        //判断是否总数 如果code存在 表示统计总数
        if(isset($request->code)){
            $orders['time']='';
            $adminOrders=DB::select("select count(orders.id)as num,shops.shop_name from orders JOIN shops on orders.shop_id=shops.id  GROUP by orders.shop_id ORDER by num asc");
        }else{

            $adminOrders=DB::select("select count(orders.id)as num,shops.shop_name from orders JOIN shops on orders.shop_id=shops.id  where orders.created_at like ? GROUP by orders.shop_id ORDER by num asc",[$current]);

        }

        foreach ($adminOrders as $order){
            $orders['count'][]=$order->num;
            $orders['shop_name'][]=$order->shop_name;
        }
        echo json_encode($orders);

    }
     //菜品统计
    public function  menuCount(Request $request)
    {

        //准备一个空数组重组数据 返回json
        $menuCount=[];
        //菜品销量统计[按商家分别统计]（每日、每月、总计）

        $where_time=$request->day??date('Y-m-d');

        //存储搜索条件，做回显
        $menuCount['time']=$where_time;

        //拼接搜索条件
        $where_time=$where_time.'%';
        //搜索月份

        if(isset($request->month)){
            $where_time=$request->month;
            //如果月份存在按月份搜索。并存储搜索条件
            $menuCount['time']=$where_time;
            $where_time.='%';
        }

        //判断是否总数 如果code存在 表示统计总数
        if(isset($request->code)){
            $menuCount['time']='';
            $Menuorders=DB::select("select sum(amount)as num,menus.goods_name,shops.shop_name from orders as os join order_goods as og on os.id=og.order_id join menus on og.goods_id=menus.id join shops on os.shop_id=shops.id  GROUP BY menus.id,shops.id ORDER BY num ASC
");
        }else{
            $Menuorders=DB::select("select sum(amount)as num,menus.goods_name,shops.shop_name from orders as os join order_goods as og on os.id=og.order_id join menus on og.goods_id=menus.id join shops on os.shop_id=shops.id where  os.created_at like ? GROUP BY shops.id,menus.id ORDER BY num ASC ",[$where_time]);
        }

        foreach ($Menuorders as $menu){
            $menuCount['count'][]=$menu->num;
            $menuCount['goods_name'][]=$menu->shop_name.'-------'.$menu->goods_name;
        }

       echo json_encode($menuCount);


    }
    //整体统计
    public function overall(Request $request)
    {

        $current=date('Y-m-d').'%';

        if(isset($request->Month)){

            $current=substr($request->Month,0,7).'%';
        }

        $day=$request->Day;

        if(isset($day)){
            $current=$day.'%';
        }

        //判断是否总数 如果code存在 表示统计总数
        if(isset($request->code)){
            $overalls=DB::select("select sum(amount)as num,menus.goods_name,shops.shop_name from orders as os join order_goods as og on os.id=og.order_id join menus on og.goods_id=menus.id join shops on os.shop_id=shops.id  GROUP BY shops.id,menus.id ORDER BY num desc
");
        }else{
            $overalls=DB::select("select sum(amount)as num,menus.goods_name,shops.shop_name from orders as os join order_goods as og on os.id=og.order_id join menus on og.goods_id=menus.id join shops on os.shop_id=shops.id where  os.created_at like '{$current}' GROUP BY menus.id,shops.id ORDER by num desc
");
        }

        return view('order.overall',compact('overalls','day'));
    }
}
