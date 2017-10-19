<?php

namespace App\Repositories;

use App\Model\Category;

class CategoryRepository {
    use BaseRepository;

    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }


}