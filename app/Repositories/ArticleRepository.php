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

    public function getByIdWith($id)
    {
        $data = $this->model->findOrFail($id);
        $data->category;
        $data->tags;
        return $data->toArray();
    }

    public function getHomeData($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $data = $this->model->with('category', 'tags', 'user')->orderBy($sortColumn, $sort)->paginate($number);
        return $data;
    }

    public function syncTag(array $tags)
    {
        $this->model->tags()->sync($tags);
    }

    public function getBySlug($slug)
    {
        $article = $this->model->with('category', 'tags', 'user')->where('slug', $slug)->firstOrFail();

        $article->increment('view_count');

        $this->visitor->log($article->id);
        return $article;
    }
}