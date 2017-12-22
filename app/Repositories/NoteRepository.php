<?php

namespace App\Repositories;

use App\Model\Note;

class NoteRepository {

    use BaseRepository;

    protected $model;

    public function __construct(Note $note)
    {
        $this->model = $note;
    }

    public function all()
    {
        return $this->model->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->get();
    }
}