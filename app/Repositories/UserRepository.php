<?php

namespace App\Repositories;

use App\Model\User;

class UserRepository {

    use BaseRepository;

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * 通过登录类型和id判断用户是否存在
     *
     * @param $type
     * @param $id
     * @return mixed
     */
    public function getUserByTypeAndId($type, $id)
    {
        return $this->model->where('type',$type)->where('openid', $id)->first();
    }
}