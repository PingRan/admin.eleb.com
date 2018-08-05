<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventPrize;
use App\Models\EventUser;
use App\Models\PrizeUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>[],
        ]);
    }
    //抽奖活动列表
    public function index()
    {
       $events=Event::all();
       return view('event.index',compact('events'));
    }
    //添加抽奖活动
    public function create()
    {
        return view('event.create');
    }
    //添加保存
    public function store(Request $request)
    {

        $this->validate($request,
            [
             'title'=>['required','between:2,50','unique:events'],
             'content'=>['required'],
             'signup_start'=>['required','after:now'],
             'signup_end'=>['required','after:signup_start'],
             'signup_num'=>['required'],
             'prize_date'=>['required','after:signup_end'],
            ],
            [
                'title.required'=>'请填写活动标题',
                'title.between'=>'活动标题在2-50个字',
                'title.unique'=>'活动标题已存在',
                'content.required'=>'活动内容不能为空',
                'signup_start.required'=>'请选择活动报名开始时间',
                'signup_start.after'=>'活动报名开始时间,不能小于当前时间',
                'signup_end.required'=>'请选择活动报名结束时间',
                'signup_end.after'=>'活动报名结束时间,应在活动开始之后',
                'signup_num.required'=>'请设置活动报名人数',
                'prize_date.required'=>'请选择开奖 日期',
            ]
        );


        $request->is_prize=0;
        $request['signup_start']=strtotime($request->signup_start);
        $request['signup_end']=strtotime($request->signup_end);

        Event::create($request->input());

        session()->flash('success','发布活动成功');

        return redirect()->route('events.index');
    }

    public function edit(Event $event)
    {
        return view('event.edit',compact('event'));
    }
    //修稿保存
    public function update(Request $request,Event $event)
    {
        $this->validate($request,
            [
                'title'=>['required','between:2,50',Rule::unique('events')->ignore($event->id)],
                'content'=>['required'],
                'signup_start'=>['required','after:now'],
                'signup_end'=>['required','after:signup_start'],
                'signup_num'=>['required'],
                'prize_date'=>['required','after:signup_end'],
            ],
            [
                'title.required'=>'请填写活动标题',
                'title.between'=>'活动标题在2-50个字',
                'title.unique'=>'活动标题已存在',
                'content.required'=>'活动内容不能为空',
                'signup_start.required'=>'请选择活动报名开始时间',
                'signup_start.after'=>'活动报名开始时间,不能小于当前时间',
                'signup_end.required'=>'请选择活动报名结束时间',
                'signup_end.after'=>'活动报名结束时间,应在活动开始之后',
                'signup_num.required'=>'请设置活动报名人数',
                'prize_date.required'=>'请选择开奖 日期',
                'prize_date.after'=>'开奖时间必须在报名结束之后'
            ]
        );


        $request->is_prize=0;
        $signup_start=strtotime($request->signup_start);
        $signup_end=strtotime($request->signup_end);

        $event->update(['title'=>$request->title,'content'=>$request->content,'signup_start'=>$signup_start,'signup_end'=>$signup_end,'prize_date'=>$request->prize_date,'signup_num'=>$request->signup_num]);

        session()->flash('success','修改活动成功');

        return redirect()->route('events.index');
    }
    //删除
    public function destroy(Event $event)
    {
        $event->delete();
        echo 1;
    }
    //查看活动详情
    public function show(Event $event)
    {
        return view('event.show',compact('event'));
    }
    //开始抽奖
    public function startLottery(Event $event)
    {
        //判断开奖日期
        $time=time();
        $perizedate=strtotime($event->prize_date);
        if($time<$perizedate){
            session()->flash('danger','还未到开奖日期');
            return redirect()->route('events.index');
        }
        //判断是否已经开奖了，不能重复开奖
        if($event->is_prize){
            session()->flash('danger','已经开过奖了');
           return redirect()->route('events.index');
        }

        //参与抽奖活动的商家id
        $eventinfo=EventUser::where('events_id',$event->id)->get();
        //先随机取出商家id
        $user_Id=[];
        $count=[];//用来控制抽奖的循环次数
        foreach ($eventinfo as $e){
            $user_Id[]=$e->user_id;
            $count[]=$e->user_id;
        }

        //准备抽奖活动的奖品
        $prizes=EventPrize::where('events_id',$event->id)->where('num','>',0)->get();
        //准备一个奖品数组
        $prize_all=[];
        $prizeCount=0;//奖品总数
        foreach ($prizes as $prize){
            $prize_all[$prize->id]=$prize->pro->random;
            $prizeCount.=$prize->num;
        }
        
        //解决抽奖次数问题   用报名人数和奖品总数小的一个值，作为抽奖次数
        $result=[];
        $number=count($count)>$prizeCount?$prizeCount:count($count);

        for ($i=0;$i<$number;$i++){
            $result[]=$this->get_rand($prize_all,$user_Id,$event);
        }

        //将中奖信息保存到奖品商家表中
        PrizeUser::insert($result);

        $event->update(['is_prize'=>1]);

        session()->flash('success','开奖成功');

        //给中奖商家发送邮件提醒;
        //遍历中奖商家，拿到邮箱;
        foreach ($result as $res){
            $email=User::find($res['user_id'])->email;

            $content='恭喜您,在'.$event->title.'中得奖品'.$res['prize_name'];

            $title='开奖信息';

            $this->sendEmail($title,$content,$email);
        }

        return redirect()->route('events.index');

    }
    //抽奖概率算法   返回中奖的商家id和奖品名称和活动id的一维数组
    public function get_rand(&$prize_all,&$user_Id,$event)
    {
        //随机出现的商家id
        $userkey=array_rand($user_Id);//随机弹出中奖的商家的键。
        $userId=$user_Id[$userkey];

//        $userId=array_random($user_Id,1)[0];random随机弹出商家的值。

        //根据传入的数组 计算出元素的总和
        $proSum=array_sum($prize_all);
       $result='';
       foreach ($prize_all as $k=>$prizePro){
           $rand=mt_rand(1,$proSum);//得到一个1-数组元素总和的随机数.
           if($rand<=$prizePro){//如果小于这个奖品的概率 表示中奖
               $result=$k;
               break;
           }else{
               $proSum -= $prizePro;
           }
       }

        $Winning=EventPrize::find($result);
        //定一个中奖品数组
        $winarr=['user_id'=>$userId,'prize_name'=>$Winning->name,'events_id'=>$event->id];

        $Winning->update(['num'=>$Winning->num-1]);
        //判断奖品是否还有如果被抽完了 从奖品池删除
        if($Winning->num==0){
            unset($prize_all[$result]);
        }

        unset($user_Id[$userkey]);

        return $winarr;
    }
    //邮件方法
    public function sendEmail($title,$content,$email)
    {
        $r =\Illuminate\Support\Facades\Mail::send('Email', ['content'=>$content], function ($message)use($title,$content,$email) {
            $message->from('pingran1993@163.com', 'eleb平台');
            $message->to([$email])->subject($title);
        });
    }




}