@extends('default')
@section('content')
    <p>账号:{{$admin->name}}</p>
    <p>密码:{{$admin->email}}</p>
@endsection