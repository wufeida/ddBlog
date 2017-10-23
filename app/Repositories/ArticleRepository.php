<?php

namespace App\Repositories;

use App\Model\Article;

class ArticleRepository {

    use BaseRepository;

    protected $model;

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function getByIdWith($id)
    {
        $data = $this->model->findOrFail($id);
        $data->category;
        $data->tags;
        return $data->toArray();
    }

    public function syncTag(array $tags)
    {
        $this->model->tags()->sync($tags);
    }

}