<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ConfigRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ConfigController extends Controller
{
    protected $config;

    public function __construct(ConfigRepository $config)
    {
        $this->config = $config;
    }
    
    public function index()
    {
        $data = $this->config->getConfig();
        return view('admin.config', compact('data'));
    }

    public function upConfig(Request $request)
    {
        $data = $request->all();
        $data['water_status']        = isset($data['water_status']);
        $data['footer_qq_status']    = isset($data['footer_qq_status']);
        $data['footer_github_status']    = isset($data['footer_github_status']);
        $info = $this->config->getConfig();
        if ($info) {
            $res = $this->config->update($info->id, $data);
        } else {
            $res = $this->config->store($data);
        }
        if ($res) {
            return custom_json('success', '更新成功');
        }
        return custom_json('error', '更新失败');
    }

    /**
     * 获取配置项
     *
     * @return mixed
     */
    public function getConfig()
    {
        return Cache::remember('home-config', 10080, function () {
            return $this->config->getConfig();
        });
    }
}
