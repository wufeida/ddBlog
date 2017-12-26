<?php

namespace App\Repositories;

use App\Model\Article;
use Illuminate\Support\Facades\DB;

class ArticleRepository {

    use BaseRepository;

    protected $model;

    protected $visitor;

    public function __construct(Article $article,
                                VisitorRepository $visitor)
    {
        $this->model = $article;

        $this->visitor = $visitor;
    }

    /**
     * 指定id 关联分类和标签
     *
     * @param $id
     * @return mixed
     */
    public function getByIdWith($id)
    {
        $data = $this->model->findOrFail($id);
        $data->category;
        $data->tags;
        return $data->toArray();
    }

    /**
     * 前台 获取首页文章
     *
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getHomeData($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $data = $this->model->draft()->published()->with('category', 'tags', 'user')->orderBy($sortColumn, $sort)->paginate($number);
        return $data;
    }

    /**
     * 前台 获取推荐文章列表
     *
     * @return mixed
     */
    public function getRecommend()
    {
        $data = $this->model->recommend()->draft()->published()->orderBy('sort', 'asc')->orderBy('id', 'desc')->get();
        return $data;
    }

    /**
     * 获取推荐文章列表
     *
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return mixed
     */
    public function recommend($sort = 'asc', $sortColumn = 'sort')
    {
        $data = $this->model->recommend()->orderBy($sortColumn, $sort)->orderBy('id', 'desc')->get();
        return $data;
    }

    /**
     * 同步标签
     *
     * @param array $tags
     */
    public function syncTag(array $tags)
    {
        $this->model->tags()->sync($tags);
    }

    /**
     * 前台 通过slug获取文章
     *
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function getBySlug($slug)
    {
        $article = $this->model->draft()->published()->with('category', 'tags', 'user')->where('slug', $slug)->firstOrFail();

        return $article;
    }

    /**
     * 前台 通过slug获取文章id
     *
     * @param $slug
     * @return mixed
     */
    public function getIdBySlug($slug)
    {
        return $this->model->where('slug', $slug)->select('id')->first();
    }

    /**
     * 前台 获取上一篇文章
     *
     * @param $id
     * @return mixed
     */
    public function getNextArticle($id)
    {
        $id = $this->model->draft()->published()->where('id', '<', $id)->max('id');
        if ($id) {
            return $this->getById($id);
        }
        return null;
    }

    /**
     * 前台 获取下一篇文章
     *
     * @param $id
     * @return mixed
     */
    public function getPrevArticle($id)
    {
        $id = $this->model->draft()->published()->where('id', '>', $id)->min('id');
        if ($id) {
            return $this->getById($id);
        }
        return null;
    }

    /**
     * 前台 通过分类id获取文章
     *
     * @param $id
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return mixed
     */
    public function getListByCategoryId($id, $number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $data = $this->model->draft()->published()->where('category_id', $id)->with('category', 'tags', 'user')->orderBy($sortColumn, $sort)->paginate($number);
        return $data;
    }

    /**
     * 前台 通过标签id获取文章
     *
     * @param $id
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListByTagId($id, $number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $data = $this->model->with('category', 'tags', 'user')
                            ->draft()
                            ->published()
                            ->whereHas('tags', function ($q) use ($id) {
                                $q->where('id', '=', $id);
                            })
                            ->orderBy($sortColumn, $sort)
                            ->paginate($number);
        return $data;

    }

    /**
     * 前台 搜索文章
     *
     * @param $keywords
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return mixed
     */
    public function searchBykeywords($keywords, $number = 10, $sort = 'desc', $sortColumn = 'published_at')
    {
        $data = $this->model->with('category', 'tags', 'user')
            ->draft()
            ->published()
            ->where('title', 'like', "%$keywords%")
            ->orderBy($sortColumn, $sort)
            ->paginate($number);
        return $data;
    }

    public function getTimeLine()
    {
        $yearData = $this->model
            ->draft()
            ->published()
            ->select(DB::raw('date_format(published_at,"%Y") as year'))
            ->groupBy(DB::raw('date_format(published_at,"%Y")'))
            ->orderBy('year', 'desc')
            ->get();
        if ($yearData) {
            $yearData = $yearData->toArray();
        }
        if ($yearData) {
            foreach ($yearData as $v) {
                $month = $this->model
                    ->draft()
                    ->published()
                    ->whereBetween('published_at',[$v['year']."-01-01 00:00:00",$v['year']."-12-31 23:59:59"])
                    ->select(DB::raw('date_format(published_at,"%m") as month'))
                    ->groupBy(DB::raw('date_format(published_at,"%m")'))
                    ->orderBy('month', 'desc')
                    ->get();
                if ($month) {
                    $month = $month->toArray();
                    foreach ($month as $val) {
                        $data = $this->model
                            ->draft()
                            ->published()
                            ->whereBetween('published_at',[$v['year']."-".$val['month']."-01 00:00:00",$v['year']."-".$val['month']."-31 23:59:59"])
                            ->with('category','tags')
                            ->orderBy('published_at', 'desc')
                            ->get();
                        if ($data) {
                            $data = $data->toArray();
                        }
                        $timeLine[$v['year']][$val['month']] = $data;

                    }
                }
            }
        }
        if ($timeLine) {
            return $timeLine;
        }
        return null;
    }
}