<?php

namespace App\Repositories;

trait BaseRepository {
    /**
     * 获取总数
     *
     * @return array
     */
    public function getNumber()
    {
        return $this->model->count();
    }

    /**
     * 更新某一字段
     *
     * @param $id
     * @param $input
     * @return App\Model|User
     */
    public function updateColumn($id, $input)
    {
        $this->model = $this->getById($id);

        foreach ($input as $key => $value) {
            $this->model->{$key} = $value;
        }

        return $this->model->save();
    }

    /**
     * 删除指定id数据
     *
     * @param  $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }

    /**
     * 获取指定id数据
     *
     * @return App\Model
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * 获取全部数据
     *
     * @return array User
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * 获取分页数据
     *
     * @param  int $number
     * @param  string $sort
     * @param  string $sortColumn
     * @return Paginate
     */
    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * 保存数据
     *
     * @param  $input
     * @return User
     */
    public function store($input)
    {
        return $this->save($this->model, $input);
    }

    /**
     * 更新数据
     *
     * @param  $id
     * @param  $input
     * @return User
     */
    public function update($id, $input)
    {
        $this->model = $this->getById($id);

        return $this->save($this->model, $input);
    }

    /**
     * 保存数据
     *
     * @param  $model
     * @param  $input
     * @return User
     */
    public function save($model, $input)
    {
        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * 获取全部已删除内容
     *
     * @return mixed
     */
    public function getTrash()
    {
       return $this->model->onlyTrashed()->get();
    }

    /**
     * 删除单一数据
     *
     * @param $id
     * @return mixed
     */
    public function forceDelById($id)
    {
        return $this->model->where('id', $id)->forceDelete();
    }

    public function forceDelAll()
    {
        return $this->model->onlyTrashed()->forceDelete();
    }
}