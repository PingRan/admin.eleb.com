@extends('default')
@section('content')
    <h1>{{$event->title}}</h1>
    <h3>活动时间:{{date('Y-m-d',$event->signup_start)}}-{{date('Y-m-d',$event->signup_end)}}</h3>
    {!! $event->content !!}
@endsection
