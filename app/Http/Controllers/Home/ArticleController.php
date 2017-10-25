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
        $data = $this->article->getHomeData(10, 'desc', 'id');
        dd($data);
        return view('home.article', compact('data'));
    }

    public function show($slug)
    {
        $data = $this->article->getBySlug($slug);
        $data->category;
        dd($data);
        return view('home.detail', compact('data'));
    }
}
