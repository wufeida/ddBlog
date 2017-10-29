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
     * 获取首页文章
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getHomeData($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $data = $this->model->with('category', 'tags', 'user')->orderBy($sortColumn, $sort)->paginate($number);
        return $data;
    }

    /**
     * 同步标签
     * @param array $tags
     */
    public function syncTag(array $tags)
    {
        $this->model->tags()->sync($tags);
    }

    /**
     * 通过slug获取文章
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function getBySlug($slug)
    {
        $article = $this->model->with('category', 'tags', 'user')->where('slug', $slug)->firstOrFail();

        $article->increment('view_count');

        $this->visitor->log($article->id);
        return $article;
    }

    /**
     * 获取上一篇文章
     * @param $id
     * @return mixed
     */
    public function getPrevArticle($id)
    {
        $id = $this->model->where('id', '<', $id)->max('id');
        if ($id) {
            return $this->getById($id);
        }
        return null;
    }

    /**
     * 获取下一篇文章
     * @param $id
     * @return mixed
     */
    public function getNextArticle($id)
    {
        $id = $this->model->where('id', '>', $id)->min('id');
        if ($id) {
            return $this->getById($id);
        }
        return null;
    }
}