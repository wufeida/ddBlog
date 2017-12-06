<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Admin\ConfigController;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\VisitorRepository;
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
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Input::get('page')) {
            $key = 'list-home-'.Input::get('page');
        } else {
            $key = 'list-home-1';
        }
        if (Cache::tags('home-list')->has($key)) {
            $data = Cache::tags('home-list')->get($key);
        } else {
            if ($this->config == false) {
                $data = $this->article->getHomeData(10, 'desc', 'published_at');
            } else {
                $data = $this->article->getHomeData($this->config->article_number, $this->config->article_sort,$this->config->article_sortColumn);
            }

            Cache::tags('home-list')->forever($key, $data);
        }
        return view('home.index', compact('data'));
    }

    /**
     * 文章页以及上一篇下一篇
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug, Request $request)
    {
        $article_id = $this->article->getIdBySlug($slug);
        if ($article_id == false) return view('404');
        $id = $article_id->id;
        // 缓存评论
        $comments_key = 'article-comments-'.$id;
        if (Cache::tags('comment')->has($comments_key)) {
            $comments = Cache::tags('comment')->get($comments_key);
        } else {
            $comments = $this->comment->getByArticleId($id);
            Cache::tags('comment')->forever($comments_key, $comments);
        }
        //缓存文章
        $key = 'article-'.$id;
        if (Cache::has($key)) {
            $data = Cache::get($key);
        } else {
            $data = $this->article->getBySlug($slug);
            Cache::forever($key, $data);
        }

        $prev_article = $this->article->getPrevArticle($data->id);
        $next_article = $this->article->getNextArticle($data->id);

        //添加点击次数和查看日志
        $ipCache = 'article-'.$request->ip().':'.$id;
        if (!Cache::has($ipCache)) {
            $data->increment('view_count');
            $this->visitor->log($id);
            Cache::put($ipCache, '', 1440);
        }

        return view('home.article', compact('data', 'prev_article', 'next_article','comments'));
    }

    /**
     * 分类对应的文章页
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($id)
    {
        if (Input::get('page')) {
            $key = 'list-category-'.$id.'-'.Input::get('page');
        } else {
            $key = 'list-category-'.$id.'-1';
        }
        if (Cache::tags('home-list')->has($key)) {
            $data = Cache::tags('home-list')->get($key);
        } else {
            if ($this->config == false) {
                $data = $this->article->getListByCategoryId($id, 10, 'desc','published_at');
            } else {
                $data = $this->article->getListByCategoryId($id, $this->config->article_number, $this->config->article_sort,$this->config->article_sortColumn);
            }

            Cache::tags('home-list')->forever($key, $data);
        }
        return view('home.index', compact('data', 'id'));
    }

    /**
     * 标签对应的文章页
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag($id)
    {
        if (Input::get('page')) {
            $key = 'list-tag-'.$id.'-'.Input::get('page');
        } else {
            $key = 'list-tag-'.$id.'-1';
        }
        if (Cache::tags('home-list')->has($key)) {
            $data = Cache::tags('home-list')->get($key);
        } else {
            if ($this->config == false) {
                $data = $this->article->getListByTagId($id, 10, 'desc','published_at');
            } else {
                $data = $this->article->getListByTagId($id, $this->config->article_number, $this->config->article_sort,$this->config->article_sortColumn);
            }
            Cache::tags('home-list')->forever($key, $data);
        }
        return view('home.index', compact('data'));
    }

    /**
     * 搜索文章
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $keywords = Input::get('keywords');
        if ($this->config == false) {
            $data = $this->article->searchBykeywords($keywords, 10, 'desc','published_at');
        } else {
            $data = $this->article->searchBykeywords($keywords,  $this->config->article_number, $this->config->article_sort,$this->config->article_sortColumn);
        }
        return view('home.index', compact('data', 'keywords'));
    }
}
