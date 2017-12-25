<?php

namespace App\Http\Controllers\Home;

use App\Repositories\ArticleRepository;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TimeLineController extends Controller
{
    public function index(ArticleRepository $article)
    {
        $data = $article->getTimeLine();
        return view('home.timeline');
    }
}
