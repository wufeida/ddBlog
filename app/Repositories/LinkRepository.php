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

}