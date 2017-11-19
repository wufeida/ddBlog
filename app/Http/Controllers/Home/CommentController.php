<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepository;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data['user_id'] = 1;
        $data['commentable_type'] = 'articles';
        $data['commentable_id'] = 5;
        $res = $this->comment->store($data);
        return custom_json($res);
    }
}
