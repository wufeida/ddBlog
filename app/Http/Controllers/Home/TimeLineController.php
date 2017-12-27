<?php

namespace App\Http\Controllers\Home;

use App\Repositories\ArticleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TimeLineController extends Controller
{
    public function index(ArticleRepository $article)
    {
        $key = 'timeline';
        if (Cache::tags('home-list')->has($key)) {
            $data = Cache::tags('home-list')->get($key);
        } else {
            $data = $article->getTimeLine();
            Cache::tags('home-list')->forever($key, $data);
        }
        $id = 'time';
        return view('home.timeline', compact('data', 'id'));
    }
}
