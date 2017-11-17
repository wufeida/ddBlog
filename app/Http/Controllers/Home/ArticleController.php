<?php

namespace App\Http\Controllers\Home;

use App\Repositories\ArticleRepository;
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
    public function __construct(ArticleRepository $article,VisitorRepository $visitor)
    {
        $this->article = $article;
        $this->visitor = $visitor;
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
            $key = 'homeArticle';
        }
        if (Cache::has($key)) {
            $data = Cache::get($key);
        } else {
            $data = $this->article->getHomeData(config('blog.article.number'), config('blog.article.sort'), config('blog.article.sortColumn'));
            Cache::forever($key, $data);
        }
        return view('home.index', compact('data'));
    }

    /**
     * 文章页以及上一篇下一篇
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $id = $this->article->getIdBySlug($slug)->id;
        $key = 'article-'.$id;
        if (Cache::has($key)) {
            $data = Cache::get($key);
        } else {
            $data = $this->article->getBySlug($slug);
            Cache::forever($key, $data);
        }

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
        if ($this->visitor->isFirstLog($id)) {
            $data->increment('view_count');
        }
        $this->visitor->log($id);
        return view('home.article', compact('data', 'prev_article', 'next_article'));
    }

    /**
     * 分类对应的文章页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($id)
    {
        $key = 'category-'.$id;
        if (Cache::has($key)) {
            $data = Cache::get($key);
        } else {
            $data = $this->article->getListByCategoryId($id, config('blog.article.number'), config('blog.article.sort'), config('blog.article.sortColumn'));
            Cache::forever($key, $data);
        }
        return view('home.category', compact('data', 'id'));
    }

    /**
     * 标签对应的文章页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag($id)
    {
        $key = 'tag-'.$id;
        if (Cache::has($key)) {
            $data = Cache::get($key);
        } else {
            $data = $this->article->getListByTagId($id, config('blog.article.number'), config('blog.article.sort'), config('blog.article.sortColumn'));
            Cache::forever($key, $data);
        }
        return view('home.tag', compact('data'));
    }
}
