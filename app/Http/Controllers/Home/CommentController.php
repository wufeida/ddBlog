<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Admin\ConfigController;
use App\Http\Requests\CommentRequest;
use App\Jobs\SendCommentEmail;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{

    protected $comment;
    protected $user;
    protected $article;
    protected $config;
    public function __construct(CommentRepository $comment,
                                UserRepository $user,
                                ArticleRepository $article,
                                ConfigController $config)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->article = $article;
        $this->config = $config->getConfig();
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
        if (isset($data['email']) && $data['email'] && $uid !== 1) {
            $email = check('邮箱', 'email',$data['email']);
            if ($email[0] === 'error') return custom_json('error', $email[1]);
            $this->user->update($uid, ['email'=>$data['email']]);
        }

        //给用户发送邮箱
        $aid = $data['commentable_id'];
        $article = $this->article->getById($aid);
        if (isset($data['pid'])) {
            $reply_uid = $this->comment->getUidByPid($data['pid'])->user_id;
            if ($reply_uid !== $uid && $reply_uid !== 1) {
                $user = $this->user->getById($reply_uid);
                if ($user && $user->email && $user->email_notify) {
                    dispatch(new SendCommentEmail($user->email, Auth::user(), $article, $this->config->name.'回复'));
                }
            }
        }

        //给超级管理员发送邮箱
        if ($uid !== 1) {
            $admin = $this->user->getById(1);
            $admin_email = $admin->email;
            if ($admin_email) {
                dispatch(new SendCommentEmail($admin_email, Auth::user(), $article, '有人评论了你的文章'));
            }
        }

        //评论保存
        $res = $this->comment->store($data);
        //删除该篇文章评论缓存
        Cache::tags('comment')->forget('article-comments-'.$aid);
        return custom_json($res);
    }
}
