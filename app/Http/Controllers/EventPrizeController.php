<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventPrize;
use App\Models\Probability;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventPrizeController extends Controller
{
    //
    public function index()
    {
     $eventPrizes=EventPrize::paginate(6);


      return view('eventPrize.index',compact('eventPrizes'));
    }

    public function create()
    {
        $events=Event::all();

         $Probabilities=Probability::all();

        return view('eventPrize.create',compact('events','Probabilities'));
    }

    public function store(Request $request)
    {

        $this->validate($request,
            [
                'name'=>['required','between:2,20','unique:event_prizes'],
                'description'=>['required'],
                'events_id'=>['required'],
                'num'=>['required']
            ],
            [
                'name.required'=>'请填写奖品名称',
                'name.between'=>'奖品名称在2-20个字',
                'name.unique'=>'奖品已存在',
                'description.required'=>'奖品描述不能为空',
                'events_id.required'=>'请选择给哪个活动添加奖品',
                'num.required'=>'请输入奖品数量',
            ]
        );
        //添加奖品判断活动是不是已经开奖了
        $events_id=$request->events_id;
        $eventOne=Event::find($events_id)->first();
        //活动开奖日期的时间戳
        if($eventOne->is_prize){
            session()->flash('danger','活动已经开始了,不能添加奖品');
            return back()->withInput();
        };

        //添加奖品时 商家id不存在
        $request->user_id=0;

        EventPrize::create($request->input());

        session()->flash('success','添加奖品成功');

        return redirect()->route('eventPrizes.index');
    }

    public function edit(EventPrize $eventPrize)
    {
        //修改奖品判断活动是不是已经开始了
        $events_id=$eventPrize->events_id;
        $eventOne=Event::find($events_id)->first();
        //活动开奖日期的时间戳
        if($eventOne->is_prize){
            session()->flash('danger','活动已经开始了,不能修改这个奖品');
            return back()->withInput();
        };


        $events=Event::all();
        $Probabilities=Probability::all();

        return view('eventPrize.edit',compact('eventPrize','events','Probabilities'));
    }

    public function update(Request $request,EventPrize $eventPrize)
    {
        $this->validate($request,
            [
                'name'=>['required','between:2,20',Rule::unique('event_prizes')->ignore($eventPrize->id)],
                'description'=>['required'],
                'events_id'=>['required'],
                'num'=>['required']
            ],
            [
                'name.required'=>'请填写奖品名称',
                'name.between'=>'奖品名称在2-20个字',
                'name.unique'=>'奖品已存在',
                'description.required'=>'奖品描述不能为空',
                'events_id.required'=>'请选择给哪个活动添加奖品',
                'num.required'=>'请输入奖品数量',
            ]
        );


        $events_id=$request->events_id;
        $eventOne=Event::find($events_id)->first();
        //活动开奖日期的时间戳
        if($eventOne->is_prize){
            session()->flash('danger','活动已经开始了,不能修改奖品');
            return back()->withInput();
        };

        $eventPrize->update(['name'=>$request->name,'description'=>$request->description,'events_id'=>$request->events_id,'num'=>$request->num,'random'=>$request->random]);

        session()->flash('success','修改奖品成功');
        return redirect()->route('eventPrizes.index');
    }

    public function destroy(EventPrize $eventPrize)
    {

        $events_id=$eventPrize->events_id;
        $eventOne=Event::find($events_id)->first();
        //活动开奖日期的时间戳
        $success=['success'=>true];
        if($eventOne->is_prize){
            $success=['success'=>false];
            $res=json_encode($success);
            echo $res;
            return ;
        };
        $eventPrize->delete();
        $res=json_encode($success);
        echo $res;

    }
    //查看活动详情
    public function show(EventPrize $eventPrize)
    {
        return view('eventPrize.show',compact('eventPrize'));
    }
}
