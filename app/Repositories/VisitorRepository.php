<?php

namespace App\Repositories;


use App\Model\Visitor;
use App\Tools\IP;

class VisitorRepository {

    use BaseRepository;

    protected $model;

    protected $ip;

    public function __construct(Visitor $visitor,
                                IP $ip)
    {
        $this->model = $visitor;

        $this->ip = $ip;
    }

    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->with('article')->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * 添加点击查看日志
     *
     * @param $article_id
     */
    public function log($article_id) {
        $ip = $this->ip->get();
        if ($this->hasArticleIp($article_id, $ip)) {
            $this->model->where('article_id', $article_id)
                ->where('ip', $ip)
                ->increment('clicks');
        } else {
            $site = $this->ip->getSite();
            if ($site) {
                $country = $site['country'].' '.$site['province'].' '.$site['city'];
            } else {
                $country = null;
            }
            $data = [
                'ip'		    => $ip,
                'article_id'    => $article_id,
                'clicks' 	    => 1,
                'country'       => $country
            ];
            $this->model->firstOrCreate( $data );
        }
    }


    /**
     * 检查同一个ip的文章是否存在
     *
     * @param $atricle_id
     * @param $ip
     * @return bool
     */
    public function hasArticleIp($atricle_id, $ip)
    {
        return $this->model
            ->where('article_id', $atricle_id)
            ->where('ip', $ip)
            ->count() ? true : false;
    }


    /**
     * Get all the clicks.
     *
     * @return int
     */
    public function getAllClicks()
    {
        return $this->model->sum('clicks');
    }

}