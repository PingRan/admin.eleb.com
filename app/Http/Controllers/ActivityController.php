<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>[],
        ]);
    }

    public function index(Request $request)
    {
        $activities=Activity::paginate(6);

        if($request->code==2){
            //2表示查看未开始的活动
            $now=time();
            $activities=Activity::where('start_time','>',$now)->paginate(6);
        }

        if($request->code==1){
            //1表示查看进行中的活动
            $now=time();
            $activities=Activity::where('start_time','<',$now)->where('end_time','>',$now)->paginate(6);
        }

        if($request->code==-1){
            //-1表示查看活动结束
            $now=time();
            $activities=Activity::where('end_time','<',$now)->paginate(6);
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
              'title.unique'=>'标题已存在',
              'start_time.required'=>'活动的开始时间不能为空',
               'start_time.after'=>'活动的开始时间必须在当前时间之后',
              'end_time.required'=>'活动的结束时间不能为空',
              'end_time.after'=>'活动的结束时间不能小于当前时间',
               'content.required'=>'活动内容不能为空',
           ]
       );
       $request['start_time']=strtotime($request->start_time);
       $request['end_time']=strtotime($request->end_time);
       $activity=Activity::create($request->input());
       //生成活动静态详情
        $url=$this->createShow($activity);
        $activity->update(['static_url'=>$url]);

        //生成活动静态列表
       return $this->createList();

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

        //生成活动静态详情
        $url=$this->createShow($activity);

        $activity->update(['title'=>$request->title,'start_time'=>$start_time,'end_time'=>$end_time,'static_url'=>$url]);
        return $this->createList();
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        $this->createList();
        if(is_file('active/active'.$activity->id.'.html')){
            unlink('active/active'.$activity->id.'.html');
        }
        echo 1;
    }

    public function show(Activity $activity)
    {
        return view('activity.show',compact('activity'));
    }
    //生成活动列表静态页面/
    public function createList()
    {
        //查看未结束的活动
        $activities=Activity::where('end_time','>',time())->offset(0)->limit(6)->get();

        if(!is_dir('active')){
            mkdir('active',0777,true);
        }
         $article_List=view('activity.active_List',compact('activities'));
         file_put_contents('active/active_List.html',$article_List);

        session()->flash('success','操作成功,已更新活动静态页');
        return redirect()->route('activities.index');
    }
    //生成活动详情的静态页面方法  /返回静态页面的url地址
    public function createShow(Activity $activity){

     $content=view('activity.create_Show',compact('activity'));
     if(!is_dir('active')){
         mkdir('active',0777,true);
     }
     file_put_contents('active/active'.$activity->id.'.html',$content);
     return $url='/active/active'.$activity->id.'.html';

    }
}
