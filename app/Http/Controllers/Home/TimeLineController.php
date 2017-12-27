<?php

namespace App\Http\Controllers\Home;

use App\Repositories\ArticleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TimeLineController extends Controller
{
    public function index(ArticleRepository $article)
    {
        $data = $article->getTimeLine();
        $id = 'time';
        return view('home.timeline', compact('data', 'id'));
    }
}
