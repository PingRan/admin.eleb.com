<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //
    public function index(Request $request)
    {
        $activities=Activity::all();

        if($request->code==2){
            //2表示查看未开始的活动
            $now=time();
            $activities=Activity::where('start_time','>',$now)->get();
        }

        if($request->code==1){
            //1表示查看进行中的活动
            $now=time();
            $activities=Activity::where('start_time','<',$now)->where('end_time','>',$now)->get();
        }

        if($request->code==-1){
            //-1表示查看活动结束
            $now=time();
            $activities=Activity::where('end_time','<',$now)->get();
        }

        return view('activity.index',compact('activities'));
    }

    public function create()
    {
        return view('activity.create');
    }

    public function store(Request $request)
    {
       $this->validate($request,
           [
            'title'=>'required|max:60|unique:activities',
             'start_time'=>'required|after:now',
             'end_time'=>'required|after:start_time',
               'content'=>'required',
           ],
           [
             'title.required'=>'活动标题不能为空',
             'title.max'=>'活动标题长度在60个字以内',
              'start_time.required'=>'活动的开始时间不能为空',
               'start_time.after'=>'活动的开始时间必须在当前时间之后',
              'end_time.required'=>'活动的结束时间不能为空',
              'end_time.after'=>'活动的结束时间不能小于当前时间',
               'content.required'=>'活动内容不能为空',
           ]
       );
       $request['start_time']=strtotime($request->start_time);
       $request['end_time']=strtotime($request->end_time);
       Activity::create($request->input());

       session()->flash('success','添加成功');

       return redirect()->route('activities.index');
    }

    public function edit(Activity $activity)
    {
       return view('activity.edit',compact('activity'));
    }


    public function update(Request $request,Activity $activity)
    {

        $this->validate($request,
            [
                'title'=>'required|max:60|unique:activities,title,'.$activity->id,
                'start_time'=>'required|after:now',
                'end_time'=>'required|after:start_time',
            ],
            [
                'title.required'=>'活动标题不能为空',
                'title.max'=>'活动标题长度在60个字以内',
                'start_time.required'=>'活动的开始时间不能为空',
                'start_time.after'=>'活动的开始时间必须在当前时间之后',
                'end_time.required'=>'活动的结束时间不能为空',
                'end_time.after'=>'活动的结束时间不能小于当前时间',
            ]
        );

        $start_time=strtotime($request->start_time);

        $end_time=strtotime($request->end_time);

        $activity->update(['title'=>$request->title,'start_time'=>$start_time,'end_time'=>$end_time]);

        session()->flash('success','修改成功');

        return redirect()->route('activities.index');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        echo 1;
    }

    public function show(Activity $activity)
    {
        return view('activity.show',compact('activity'));
    }

}
