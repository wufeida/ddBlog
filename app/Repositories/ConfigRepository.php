<?php

namespace App\Repositories;

use App\Model\Config;

class ConfigRepository {

    use BaseRepository;

    protected $model;

    public function __construct(Config $config)
    {
        $this->model = $config;
    }

    public function getConfig()
    {
        return $this->model->first();
    }

}