@extends('default')

@section('content')
    <h1>菜单名字 {{$nav->name}}</h1>
    <p>菜单url  {{$nav->url}} 菜单权限id{{$nav->permission_id}}</p>

@endsection
