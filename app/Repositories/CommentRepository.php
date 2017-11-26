<?php

namespace App\Repositories;

use App\Model\Comment;
use App\Model\User;

class CommentRepository
{
    use BaseRepository;

    protected $model;

    private $child = [];
    public function __construct(Comment $Comment)
    {
        $this->model = $Comment;
    }

    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->with('commentable')->with('user')->orderBy($sortColumn, $sort)->paginate($number);
    }

    public function getByArticleId($id)
    {
        $data = $this->model->with('user')
            ->where('commentable_type', 'articles')
            ->where('commentable_id', $id)
            ->where('pid', 0)
            ->orderBy('created_at','desc')
            ->get()
            ->toArray();
        foreach ($data as $k=>$v) {
            // 获取二级评论
            $this->child = [];
            $this->getTree($v, $id);
            $child = $this->child;
            if (!empty($child)) {
                // 按评论时间asc排序
                uasort($child, function ($a, $b) {
                    $prev = isset($a['created_at']) ? $a['created_at'] : 0;
                    $next = isset($b['created_at']) ? $b['created_at'] : 0;
                    if ($prev == $next) return 0;
                    return ($prev < $next) ? -1 : 1;
                });
                foreach ($child as $m => $n) {
//                    // 获取被评论人id
                    $replyUserId = $this->model->where('id', $n['pid'])->pluck('user_id');
//                    // 获取被评论人昵称
                    $oauthUserMap = [
                        'id' => $replyUserId
                    ];
                    $child[$m]['reply_name'] = User::where($oauthUserMap)->value('name');
                }
            }
            $data[$k]['child'] = $child;
        }
        return $data;
    }

    function getTree($data, $id)
    {
        $pid = $data['id'];
        $child = $this->model->with('user')
            ->where('commentable_type', 'articles')
            ->where('commentable_id', $id)
            ->where('pid', $pid)
            ->get()
            ->toArray();
        if ($child) {
            foreach ($child as $v) {
                if ($v['pid'] == $pid) {
                    $this->child[] = $v;
                    $this->getTree($v, $id);
                }
            }
        }
    }

    /**
     * 获取用户最近评论数据
     *
     * @param $id
     * @return mixed
     */
    public function getNewByUid($id)
    {
        return $this->model->where('user_id', $id)->orderBy('id', 'desc')->first();
    }

    /**
     * 获取用户一天内评论总数
     *
     * @param $id
     * @return mixed
     */
    public function getOneDayUserCount($id)
    {
        $time = date('Y-m-d');
        return $this->model->where('user_id', $id)->whereBetween('created_at',[$time.' 00:00:00', $time.' 23:59:59'])->count();
    }

    /**
     * 通过pid获取用户id
     *
     * @param $pid
     * @return mixed
     */
    public function getUidByPid($pid)
    {
        return $this->model->where('id', $pid)->select('user_id')->first();
    }
}