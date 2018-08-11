<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $content;
    protected $title;
    protected $user;
    public function __construct($email,$content,$title)
    {
        //
        $this->content=$content;
        $this->title=$title;
        $this->user=$email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::raw($this->content,function ($message){
            // 发件人（你自己的邮箱和名称）
            $message->from('pingran1993@163.com','通知信息');
            // 收件人的邮箱地址
            $message->to($this->user);
            // 邮件主题
            $message->subject($this->title);
        });
    }
}
