@extends('default')
@section('content')
    <h1>{{$category->cate_name}}</h1>
    <h3>{{$category->cate_desc}}</h3>
    <p>{{$category->pid}}</p>
@endsection