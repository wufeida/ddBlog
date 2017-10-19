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


}