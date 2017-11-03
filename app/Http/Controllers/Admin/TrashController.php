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
        return view('admin.trash',compact('data'));
    }
}
