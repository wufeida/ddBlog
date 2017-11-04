<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\LinkRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrashController extends Controller
{

    protected $article;

    protected $tag;

    protected $link;

    protected $comment;

    protected $category;

    public function __construct(ArticleRepository $article,
                                TagRepository $tag,
                                LinkRepository $link,
                                CommentRepository $comment,
                                CategoryRepository $category)
    {
        $this->article  = $article;
        $this->tag      = $tag;
        $this->link     = $link;
        $this->comment  = $comment;
        $this->category = $category;
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
        $collection = collect([$articles, $tags, $links, $comments, $categories]);
        //合并集合
        $collapsed = $collection->collapse();
        //按最新删除时间排序
        $data = $collapsed->sortByDesc('deleted_at');
        return view('admin.trash',compact('data', 'articles', 'tags', 'links', 'comments', 'categories'));
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
        return 1;
    }
}
