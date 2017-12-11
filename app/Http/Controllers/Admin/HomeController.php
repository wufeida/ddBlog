<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    //后台首页显示
    public function index()
    {
        $pdo     = \DB::connection()->getPdo();
        $version = $pdo->query('select version()')->fetchColumn();
        $remote_host = Request()->getClientIp();
        $data = [
            'server'          => $_SERVER['SERVER_SOFTWARE'],
            'http_host'       => $_SERVER['HTTP_HOST'],
            'remote_host'     => $remote_host,
            'user_agent'      => $_SERVER['HTTP_USER_AGENT'],
            'php'             => phpversion(),
            'sapi_name'       => php_sapi_name(),
            'extensions'      => implode(", ", get_loaded_extensions()),
            'db_connection'   => isset($_SERVER['DB_CONNECTION']) ? $_SERVER['DB_CONNECTION'] : 'Secret',
            'db_database'     => isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : 'Secret',
            'db_version'      => $version,
        ];
        return view('admin/index')->with(compact('data'));
    }

    /**
     * 清除所有缓存
     */
    public function cache()
    {
        if(Cache::flush()) {
            return 1;
        }
        return 0;
    }
}
