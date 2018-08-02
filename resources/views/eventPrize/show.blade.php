@extends('default')
@section('content')
    <h1>{{$eventPrize->name}}</h1>
    <h3>所属活动{{$eventPrize->eventName->title}}</h3>
    {!! $eventPrize->description !!}
@endsection
