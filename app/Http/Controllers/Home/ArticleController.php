<?php

namespace App\Http\Controllers\Home;

use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    protected $article;

    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    public function index()
    {
        $data = $this->article->getHomeData(2, 'desc', 'id');
        return view('home.index', compact('data'));
    }

    public function show($slug)
    {
        $data = $this->article->getBySlug($slug);
        $prev_article = $this->article->getPrevArticle($data->id);
        $next_article = $this->article->getNextArticle($data->id);
        return view('home.article', compact('data', 'prev_article', 'next_article'));
    }
}
