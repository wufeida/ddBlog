<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\LinkRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TrashController extends Controller
{

    protected $article;

    protected $tag;

    protected $link;

    protected $comment;

    protected $category;

    protected $user;

    public function __construct(ArticleRepository $article,
                                TagRepository $tag,
                                LinkRepository $link,
                                CommentRepository $comment,
                                CategoryRepository $category,
                                UserRepository $user)
    {
        $this->article  = $article;
        $this->tag      = $tag;
        $this->link     = $link;
        $this->comment  = $comment;
        $this->category = $category;
        $this->user     = $user;
    }

    /**
     * 添加唯一标识
     *
     * @param $data
     * @param $flag
     * @return mixed
     */
    protected function flag($data, $flag)
    {
        foreach ($data as $v) {
            $v['flag'] = $flag;
        }
        return $data;
    }

    /**
     * 显示回收站数据
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $articles = $this->article->getTrash();
        $articles = $this->flag($articles, 'article');
        $tags = $this->tag->getTrash();
        $tags = $this->flag($tags, 'tag');
        $links = $this->link->getTrash();
        $links = $this->flag($links, 'link');
        $comments = $this->comment->getTrash();
        $comments = $this->flag($comments, 'comment');
        $categories = $this->category->getTrash();
        $categories = $this->flag($categories, 'category');
        $users = $this->user->getTrash();
        $users = $this->flag($users, 'user');
        $collection = collect([$articles, $tags, $links, $comments, $categories, $users]);
        //合并集合
        $collapsed = $collection->collapse();
        //按最新删除时间排序
        $data = $collapsed->sortByDesc('deleted_at');
        return view('admin.trash',compact('data', 'articles', 'tags', 'links', 'comments', 'categories', 'users'));
    }

    /**
     * 永久删除单一数据
     *
     * @param $type
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function onlyDel($type, $id)
    {
        switch ($type) {
            case 'article':
                $res = $this->article->forceDelById($id);
                return custom_json($res);
                break;
            case 'tag':
                $res = $this->tag->forceDelById($id);
                return custom_json($res);
                break;
            case 'link':
                $res = $this->link->forceDelById($id);
                return custom_json($res);
                break;
            case 'category':
                $res = $this->category->forceDelById($id);
                return custom_json($res);
                break;
            case 'comment':
                $res = $this->comment->forceDelById($id);
                return custom_json($res);
                break;
            case 'user':
                $res = $this->user->forceDelById($id);
                return custom_json($res);
                break;
        }
    }

    /**
     * 清空回收站
     */
    public function allDel()
    {
        $this->article->forceDelAll();
        $this->category->forceDelAll();
        $this->tag->forceDelAll();
        $this->link->forceDelAll();
        $this->comment->forceDelAll();
        $this->user->forceDelAll();
        return 1;
    }

    /**
     * 撤销单个删除
     *
     * @param $type
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function undo($type, $id)
    {
        switch ($type) {
            case 'article':
                $res = $this->article->undoById($id);
                Cache::tags('home-list')->flush();
                Cache::forget('site-map');
                return custom_json($res);
                break;
            case 'tag':
                $res = $this->tag->undoById($id);
                Cache::forget('home-tag');
                return custom_json($res);
                break;
            case 'link':
                $res = $this->link->undoById($id);
                Cache::forget('home-link');
                return custom_json($res);
                break;
            case 'category':
                $res = $this->category->undoById($id);
                Cache::forget('home-category');
                return custom_json($res);
                break;
            case 'comment':
                $res = $this->comment->undoById($id);
                Cache::forget('home-comment');
                Cache::tags('comment')->flush();
                return custom_json($res);
                break;
            case 'user':
                $res = $this->user->undoById($id);
                return custom_json($res);
                break;
        }
    }

    /**
     * 还原回收站所有数据
     */
    public function undoAll()
    {
        $this->article->undoAll();
        $this->category->undoAll();
        $this->tag->undoAll();
        $this->link->undoAll();
        $this->comment->undoAll();
        $this->user->undoAll();
        Cache::flush();
        return 1;
    }
}
