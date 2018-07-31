@extends('default')
@section('content')
    <h1>会员详细信息</h1>
   <table class="table table-striped table-hover table-bordered">
       <tr>
           <td>会员名字</td>
           <td>{{$member->username}}</td>
       </tr>
       <tr>
           <td>电话</td>
           <td>{{$member->tel}}</td>
       </tr>

       <tr>
           <td>注册时间</td>
           <td>{{$member->created_at}}</td>
       </tr>

       <tr>
           <td>账号状态</td>
           <td>{{$member->status?'正常':'禁用'}}</td>
       </tr>

       <tr>
           @if($member->status==1)
               <td><a class="btn btn-primary" href="{{route('editstatus',['member'=>$member,'status'=>0])}}">禁用</a></td>
               <td></td>
           @else
           <td><a class="btn btn-primary btn-lg" href="{{route('editstatus',['member'=>$member,'status'=>1])}}">启用</a></td>
               <td></td>
           @endif
       </tr>

   </table>
@endsection