<?php

namespace App\Listeners;

use App\Events\SendEmail;
use App\Mail\CommentMail;
use App\Model\User;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class CommentSendEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $user;
    protected $article;
    public function __construct(UserRepository $user, ArticleRepository $article)
    {
        $this->user = $user;
        $this->article = $article;
    }

    /**
     * Handle the event.
     *
     * @param  SendEmail  $event
     * @return void
     */
    public function handle(SendEmail $event)
    {
        $email = $event->email;
        $uid = $event->uid;
        $user = $this->user->getById($uid);
        $aid = $event->aid;
        $article = $this->article->getById($aid);
        $res = Mail::to($email)->send(new CommentMail($user, $article));
        dd($res);
    }
}
