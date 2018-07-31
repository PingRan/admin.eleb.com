@extends('default')
@section('content')
    <h1>角色详情</h1>
   <table class="table table-striped table-hover table-bordered">
       <tr>
           <td>角色名</td>
           <td>{{$role->name}}</td>
       </tr>
       <tr>
           <td>角色权限</td>
           <td>@foreach($role->permissions as $per)
               {{$per->name}}&emsp;
               @endforeach</td>
       </tr>

       <tr>
           <td>角色创建时间</td>
           <td>{{$role->created_at}}</td>
       </tr>

   </table>
@endsection