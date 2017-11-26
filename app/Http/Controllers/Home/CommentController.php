<?php

namespace App\Http\Controllers\Home;

use App\Events\SendEmail;
use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    protected $comment;
    protected $user;

    public function __construct(CommentRepository $comment, UserRepository $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $data = $request->all();
        $uid = Auth::user()->id;
        if ($uid == false) return custom_json('error', '请登录后评论');
        if (Auth::user()->status == 0) return custom_json('error' ,'该用户被禁用');
        $is_admin = Auth::user()->is_admin;
        $data['user_id'] = $uid;
        if ($is_admin !== 1) {
            $new = $this->comment->getNewByUid($uid);
            if ($new && $new->created_at->diffInSeconds(Carbon::now()) < 60) return custom_json('error', '评论频繁，稍后重试');
            $count = $this->comment->getOneDayUserCount($uid);
            if ($count >= 10) return custom_json('error', '一天内只能评论10次');
        }
        if (isset($data['email']) && $data['email']) {
            $email = check('邮箱', 'email',$data['email']);
            if ($email[0] === 'error') return custom_json('error', $email[1]);
            $this->user->update($uid, $data['email']);
        }
        if (isset($data['pid'])) {
            $reply_uid = $this->comment->getUidByPid($data['pid'])->user_id;
            $user = $this->user->getById($reply_uid);
            if ($user && $user->email && $user->email_notify) {
                event(new SendEmail($user->email));
            }
        }
        $res = $this->comment->store($data);
        return custom_json($res);
    }
}
