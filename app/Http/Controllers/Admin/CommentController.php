<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

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
        $data = $this->comment->page(10, 'desc', 'id');
        return view('admin.comment')->with(compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->comment->destroy($id);
        if ($res) {
            Cache::forget('home-comment');
            Cache::tags('comment')->flush();
        }
        return custom_json($res);
    }
}
