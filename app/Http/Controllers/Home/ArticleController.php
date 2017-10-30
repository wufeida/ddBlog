<?php

namespace App\Http\Controllers\Home;

use App\Repositories\ArticleRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    protected $article;

    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    /**
     * 首页文章列表显示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = $this->article->getHomeData(2, 'desc', 'id');
        if ($data) {
            foreach ($data as $v) {
                $v->publish_at = Carbon::createFromFormat('Y-m-d H:i:s', $v->published_at)->diffForHumans();
            }
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
        $data = $this->article->getBySlug($slug);
        $data->publish_at = Carbon::createFromFormat('Y-m-d H:i:s', $data->published_at)->diffForHumans();
        $prev_article = $this->article->getPrevArticle($data->id);
        $next_article = $this->article->getNextArticle($data->id);
        return view('home.article', compact('data', 'prev_article', 'next_article'));
    }

    /**
     * 分类对应的文章页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($id)
    {
        $data = $this->article->getListByCategoryId($id, 1, 'desc', 'id');
        if ($data) {
            foreach ($data as $v) {
                $v->publish_at = Carbon::createFromFormat('Y-m-d H:i:s', $v->published_at)->diffForHumans();
            }
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
        $data = $this->article->getListByTagId($id, 1, 'desc', 'id');
        if ($data) {
            foreach ($data as $v) {
                $v->publish_at = Carbon::createFromFormat('Y-m-d H:i:s', $v->published_at)->diffForHumans();
            }
        }
        return view('home.tag', compact('data'));
    }
}
