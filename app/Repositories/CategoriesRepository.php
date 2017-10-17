<?php

namespace App\Repositories;

use App\Model\Categories;

class CategoriesRepository {
    use BaseRepository;

    protected $model;

    public function __construct(Categories $categories)
    {
        $this->model = $categories;
    }


}