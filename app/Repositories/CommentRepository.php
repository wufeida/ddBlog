<?php

namespace App\Repositories;

use App\Model\Comment;

class CommentRepository {
    use BaseRepository;

    protected $model;

    public function __construct(Comment $Comment)
    {
        $this->model = $Comment;
    }

    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->with('commentable')->with('user')->orderBy($sortColumn, $sort)->paginate($number);
    }

}