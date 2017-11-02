<?php

namespace App\Repositories;

use App\Model\Article;

class ArticleRepository {

    use BaseRepository;

    protected $model;

    protected $visitor;

    public function __construct(Article $article,
                                VisitorRepository $visitor)
    {
        $this->model = $article;

        $this->visitor = $visitor;
    }

    /**
     * 指定id 关联分类和标签
     *
     * @param $id
     * @return mixed
     */
    public function getByIdWith($id)
    {
        $data = $this->model->findOrFail($id);
        $data->category;
        $data->tags;
        return $data->toArray();
    }

    /**
     * 前台 获取首页文章
     *
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getHomeData($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $data = $this->model->draft()->published()->with('category', 'tags', 'user')->orderBy($sortColumn, $sort)->paginate($number);
        return $data;
    }

    /**
     * 前台 获取推荐文章列表
     *
     * @return mixed
     */
    public function getRecommend()
    {
        $data = $this->model->recommend()->draft()->published()->orderBy('sort', 'desc')->orderBy('id', 'desc')->get();
        return $data;
    }

    /**
     * 获取推荐文章列表
     *
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return mixed
     */
    public function recommend($sort = 'desc', $sortColumn = 'sort')
    {
        $data = $this->model->recommend()->orderBy($sortColumn, $sort)->orderBy('id', 'desc')->get();
        return $data;
    }

    /**
     * 同步标签
     *
     * @param array $tags
     */
    public function syncTag(array $tags)
    {
        $this->model->tags()->sync($tags);
    }

    /**
     * 前台 通过slug获取文章
     *
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function getBySlug($slug)
    {
        $article = $this->model->draft()->published()->with('category', 'tags', 'user')->where('slug', $slug)->firstOrFail();
        if ($this->visitor->isFirstLog($article->id)) {
            $article->increment('view_count');
        }
        $this->visitor->log($article->id);
        return $article;
    }

    /**
     * 前台 获取上一篇文章
     *
     * @param $id
     * @return mixed
     */
    public function getNextArticle($id)
    {
        $id = $this->model->draft()->published()->where('id', '<', $id)->max('id');
        if ($id) {
            return $this->getById($id);
        }
        return null;
    }

    /**
     * 前台 获取下一篇文章
     *
     * @param $id
     * @return mixed
     */
    public function getPrevArticle($id)
    {
        $id = $this->model->draft()->published()->where('id', '>', $id)->min('id');
        if ($id) {
            return $this->getById($id);
        }
        return null;
    }

    /**
     * 前台 通过分类id获取文章
     *
     * @param $id
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return mixed
     */
    public function getListByCategoryId($id, $number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $data = $this->model->draft()->published()->where('category_id', $id)->with('category', 'tags', 'user')->orderBy($sortColumn, $sort)->paginate($number);
        return $data;
    }

    /**
     * 前台 通过标签id获取文章
     *
     * @param $id
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListByTagId($id, $number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $data = $this->model->with('category', 'tags', 'user')
                            ->draft()
                            ->published()
                            ->whereHas('tags', function ($q) use ($id) {
                                $q->where('id', '=', $id);
                            })
                            ->orderBy($sortColumn, $sort)
                            ->paginate($number);
        return $data;

    }
}