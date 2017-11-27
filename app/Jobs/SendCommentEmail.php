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
    public function __construct($email, $user, $article, $subject)
    {
        $this->user = $user;
        $this->article = $article;
        $this->email = $email;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $res = Mail::to($this->email)->send(new CommentMail($this->user, $this->article, $this->subject));
    }
}
