<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    protected $comment;

    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
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
        $uid = 1;
        $data['user_id'] = $uid;
        $new = $this->comment->getNewByUid($uid);
        if ($new && $new->created_at->diffInSeconds(Carbon::now()) < 60) return custom_json('error', '评论频繁，稍后重试');
        $count = $this->comment->getOneDayUserCount($uid);
        if ($count >= 10) return custom_json('error', '一天内只能评论10次');
        $res = $this->comment->store($data);
        return custom_json($res);
    }
}
