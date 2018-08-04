<?php

namespace App\Http\Controllers;

use App\Models\EventUser;
use Illuminate\Http\Request;

class EventUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>[],
        ]);
    }
    //显示活动报名账号列表
    public function index()
    {
        $eventUsers=EventUser::all();
        return view('eventUser.index',compact('eventUsers'));
    }
}
