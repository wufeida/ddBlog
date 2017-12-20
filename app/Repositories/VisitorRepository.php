<?php

namespace App\Repositories;


use App\Model\Visitor;
use Carbon\Carbon;

class VisitorRepository {

    use BaseRepository;

    protected $model;

    public function __construct(Visitor $visitor)
    {
        $this->model = $visitor;
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
        $ip = GetIp();
        $log = $this->hasArticleIp($article_id, $ip);
        if ($log) {
            if ($log->viewed_at->diffInSeconds(Carbon::now()) > 86400) {
                $data = [
                    'viewed_at'  => Carbon::now(),
                    'clicks'     => $log->clicks + 1,
                ];
                $this->model->where('article_id', $article_id)
                    ->where('ip', $ip)
                    ->update($data);
            } else {
                $this->model->where('article_id', $article_id)
                    ->where('ip', $ip)
                    ->increment('clicks');
            }
        } else {
            $site = GetIpLookup($ip);
            if ($site) {
                $country = $site['country'].' '.$site['province'].' '.$site['city'];
            } else {
                $country = null;
            }
            $data = [
                'ip'		    => $ip,
                'article_id'    => $article_id,
                'clicks' 	    => 1,
                'country'       => $country,
                'viewed_at'     => Carbon::now(),
            ];
            $this->model->firstOrCreate( $data );
        }
    }


    /**
     * 同一ip24小时访问同一文章 只加一次查看
     *
     * @param $article_id
     * @return bool
     */
    public function isFirstLog($article_id)
    {
        $ip = GetIp();
        $log = $this->hasArticleIp($article_id, $ip);
        if ($log) {
            return $log->viewed_at->diffInSeconds(Carbon::now()) > 86400 ? true : false;
        }
        return true;
    }

    /**
     * 获取当前文章日志
     *
     * @param $article_id
     * @param $ip
     * @return mixed
     */
    public function getLogByIp($article_id, $ip)
    {
        return $this->model
            ->where('article_id', $article_id)
            ->where('ip', $ip)
            ->first();
    }
    /**
     * 检查同一个ip的文章是否存在
     *
     * @param $atricle_id
     * @param $ip
     * @return bool
     */
    public function hasArticleIp($article_id, $ip)
    {
        return $this->model
            ->where('article_id', $article_id)
            ->where('ip', $ip)
            ->first();
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