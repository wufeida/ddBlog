<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Model\Comment;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Tools\Markdowner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{

    protected $article;

    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->article->page('10', 'desc');
        if ($data) {
            foreach ($data as $v) {
                $v->publish_at = Carbon::createFromFormat('Y-m-d H:i:s', $v->published_at)->diffForHumans();
            }
        }
        return view('admin.article')->with(compact('data'));
    }

    /**
     * 推荐文章列表
     * @return $this
     */
    public function recommend()
    {
        $data = $this->article->recommend('asc', 'sort');
        if ($data) {
            foreach ($data as $v) {
                $v->publish_at = Carbon::createFromFormat('Y-m-d H:i:s', $v->published_at)->diffForHumans();
            }
        }
        return view('admin.recommend')->with(compact('data'));
    }

    /**
     * 是否推荐按钮
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function isRecommend(Request $request, $id)
    {
        if ($request->get('is_recommend') == 'true') {
            $data['is_recommend'] = 1;
        } else {
            $data['is_recommend'] = 0;
        }
        $res = $this->article->update($id, $data);
        if ($res) {
            Cache::forget('home-recommend');
        }
        return custom_json($res);
    }

    /**
     * 推荐文章排序
     *
     * @param Request $request
     * @return int
     */
    public function sort(Request $request)
    {
        //去除数组中的空值
        $info = array_filter($request->get('data'));
        foreach ($info as $k=>$v) {
            $data['sort'] = $k;
            $res = $this->article->update($v, $data);
        }
        Cache::forget('home-recommend');
        if ($res) return 1;
    }

    public function create()
    {
        $categories = app(CategoryController::class)->getList();
        $tags = app(TagController::class)->getList();
        return view('admin.article-form')->with(compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        if ($request->get('tag') == 'null') abort('422', '标签必填');
        $formData = $request->all();
        $data = array_merge($formData, [
            'user_id'      => \Auth::id(),
            'last_user_id' => \Auth::id()
        ]);
        $data['is_draft']    = isset($data['is_draft']);
        $data['is_original'] = isset($data['is_original']);
        $content['raw'] = $data['content'];
        $content['html'] = $data['flag'] == 1 ? (new Markdowner)->convertMarkdownToHtml($data['content']) : $data['content'];
        $data['content'] = $content;
        $res = $this->article->store($data);
        $tags = explode(',', $request->get('tag'));
        $this->article->syncTag($tags);
        if ($res) {
            Cache::tags('home-list')->flush();
        }
        return custom_json($res);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->article->getByIdWith($id);
        $categories = app(CategoryController::class)->getList();
        $tags = app(TagController::class)->getList();
        return view('admin.article-form')->with(compact('data', 'categories', 'tags', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        if ($request->get('tag') == 'null') abort('422', '标签必填');
        $data = array_merge($request->all(), [
            'last_user_id' => \Auth::id()
        ]);
        $data['is_draft']    = isset($data['is_draft']);
        $data['is_original'] = isset($data['is_original']);
        $content['raw'] = $data['content'];
        $content['html'] = $data['flag'] == 1 ? (new Markdowner)->convertMarkdownToHtml($data['content']) : $data['content'];
        $data['content'] = $content;
        $res = $this->article->update($id, $data);
        $tags = explode(',', $request->get('tag'));
        $this->article->syncTag($tags);
        if ($res) {
            Cache::forget('article-'.$id);
        }
        return custom_json($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Comment $comment)
    {
        $res = $this->article->destroy($id);
        $comment->where('commentable_type', 'articles')->where('commentable_id', $id)->delete();
        if ($res) {
            Cache::tags('home-list')->flush();
            //评论缓存
            Cache::forget('home-comment');
            Cache::tags('comment')->flush();
        }
        return custom_json($res);
    }
}
