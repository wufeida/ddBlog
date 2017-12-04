<?php

namespace App\Repositories;

use App\Model\Link;

class LinkRepository {

    use BaseRepository;

    protected $model;

    public function __construct(Link $link)
    {
        $this->model = $link;
    }

    public function getAll($sort = 'asc', $sortColumn = 'sort')
    {
        return $this->model->orderBy($sortColumn, $sort)->orderBy('id', 'desc')->get();
    }

    public function getHomeLink($sort = 'asc', $sortColumn = 'sort')
    {
        return $this->model->where('status',1)->orderBy($sortColumn, $sort)->orderBy('id', 'desc')->get();
    }
}