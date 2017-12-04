<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Admin\ConfigController;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\VisitorRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

class ArticleController extends Controller
{
    protected $article;
    protected $visitor;
    protected $comment;
    protected $config;
    public function __construct(ArticleRepository $article,
                                VisitorRepository $visitor,
                                CommentRepository $comment,
                                ConfigController $config)
    {
        $this->article = $article;
        $this->visitor = $visitor;
        $this->comment = $comment;
        $this->config = $config->getConfig();
    }

    /**
     * 首页文章列表显示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Input::get('page')) {
            $key = 'homeArticle-'.Input::get('page');
        } else {
            $key = 'homeArticle-1';
        }
        if (Cache::has($key)) {
            $data = Cache::get($key);
        } else {
            $data = $this->article->getHomeData($this->config->article_number, $this->config->article_sort,$this->config->article_sortColumn);
            Cache::forever($key, $data);
        }
        return view('home.index', compact('data'));
    }

    /**
     * 文章页以及上一篇下一篇
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug, Request $request)
    {
        $article_id = $this->article->getIdBySlug($slug);
        if ($article_id == false) return view('404');
        $id = $article_id->id;
        // 缓存评论
        $comments_key = 'comments-'.$id;
        if (Cache::has($comments_key)) {
            $comments = Cache::get($comments_key);
        } else {
            $comments = $this->comment->getByArticleId($id);
            Cache::forever($comments_key, $comments);
        }
        //缓存文章
        $key = 'article-'.$id;
        if (Cache::has($key)) {
            $data = Cache::get($key);
        } else {
            $data = $this->article->getBySlug($slug);
            Cache::forever($key, $data);
        }
        //缓存上一篇下一篇
        $prevNext = 'articlePrevNext-'.$id;
        if (Cache::has($prevNext)) {
            $arr = Cache::get($prevNext);
            $prev_article = $arr['prev'];
            $next_article = $arr['next'];
        } else {
            $prev_article = $this->article->getPrevArticle($data->id);
            $next_article = $this->article->getNextArticle($data->id);
            $arr = ['prev' => $prev_article, 'next' => $next_article];
            Cache::forever($prevNext, $arr);
        }

        //添加点击次数和查看日志
        $ipCache = 'article'.$request->ip().':'.$id;
        if (!Cache::has($ipCache)) {
            $data->increment('view_count');
            $this->visitor->log($id);
            Cache::put($ipCache, '', 1440);
        }

        return view('home.article', compact('data', 'prev_article', 'next_article','comments'));
    }

    /**
     * 分类对应的文章页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($id)
    {
        if (Input::get('page')) {
            $key = 'category-'.$id.'-'.Input::get('page');
        } else {
            $key = 'category-'.$id.'-1';
        }
        if (Cache::has($key)) {
            $data = Cache::get($key);
        } else {
            $data = $this->article->getListByCategoryId($id, $this->config->article_number, $this->config->article_sort,$this->config->article_sortColumn);
            Cache::forever($key, $data);
        }
        return view('home.index', compact('data', 'id'));
    }

    /**
     * 标签对应的文章页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag($id)
    {
        if (Input::get('page')) {
            $key = 'tag-'.$id.'-'.Input::get('page');
        } else {
            $key = 'tag-'.$id.'-1';
        }
        if (Cache::has($key)) {
            $data = Cache::get($key);
        } else {
            $data = $this->article->getListByTagId($id, $this->config->article_number, $this->config->article_sort,$this->config->article_sortColumn);
            Cache::forever($key, $data);
        }
        return view('home.index', compact('data'));
    }
}
