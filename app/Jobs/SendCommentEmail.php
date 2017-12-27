<?php

namespace App\Jobs;

use App\Mail\CommentMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendCommentEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    protected $article;
    protected $email;
    protected $subject;
    protected $comment;

    /**
     * 发送邮件
     *
     * SendCommentEmail constructor.
     * @param $email 发送邮箱
     * @param $user 用户的信息 用于邮件模板使用
     * @param $article  文章信息 用户邮件模板使用
     * @param $subject  邮件主题
     * @param $comment  评论内容
     */
    public function __construct($email, $user, $article, $subject, $comment)
    {
        $this->user = $user;
        $this->article = $article;
        $this->email = $email;
        $this->subject = $subject;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $res = Mail::to($this->email)->send(new CommentMail($this->user, $this->article, $this->subject, $this->comment));
    }
}
