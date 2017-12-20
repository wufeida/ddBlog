<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix'=>'dd','namespace'=>'\Admin'],function (){
    Route::get('login','LoginController@login')->name('dd.login');
    Route::get('check','LoginController@check');
    Route::post('login','LoginController@toLogin');

    Route::group(['middleware'=>'admincheck'],function (){
        //后台首页
        Route::get('index','HomeController@index')->name('dd.index');
        //清除所有缓存
        Route::get('cache','HomeController@cache');
        //退出登录
        Route::get('logout','LoginController@logout');
        //分类
        Route::resource('category', 'CategoryController', ['except' => ['create', 'show']]);
        //标签
        Route::resource('tag', 'TagController', ['except' => ['create', 'show']]);
        //文章
        Route::resource('article', 'ArticleController', ['except' => ['show']]);
        //推荐文章显示
        Route::get('recommend', 'ArticleController@recommend');
        //推荐文章开关
        Route::post('recommend/{id}', 'ArticleController@isRecommend');
        //推荐文章排序
        Route::post('sort', 'ArticleController@sort');
        //友链
        Route::resource('link', 'LinkController', ['except' => ['create', 'show']]);
        //友链排序
        Route::post('link/sort', 'LinkController@sort');
        //浏览量显示
        Route::get('visitor','VisitorController@index');
        //评论
        Route::resource('comment', 'CommentController', ['except' => ['create', 'show', 'store', 'edit', 'update']]);
        //回收站显示
        Route::get('trash', 'TrashController@index');
        //永久删除某一个
        Route::get('del/{type}/{id}', 'TrashController@onlyDel');
        //清空回收站
        Route::get('empty', 'TrashController@allDel');
        //恢复某一项
        Route::get('undo/{type}/{id}', 'TrashController@undo');
        //恢复全部
        Route::get('undo/all', 'TrashController@undoAll');
        //文件管理显示
        Route::get('file', 'FileController@index');
        //文件删除
        Route::get('file/delete', 'FileController@deleteFile');
        //创建文件夹
        Route::post('folder', 'FileController@createFolder');
        //删除文件夹
        Route::delete('folder', 'FileController@deleteFolder');
        //删除文件到管理
        Route::post('upload', 'FileController@uploadForManager');
        //上传文件接口
        Route::post('file/upload', 'FileController@fileUpload');
        //用户管理
        Route::resource('user', 'UserController', ['except' => ['create', 'show']]);
        //配置显示
        Route::get('config', 'ConfigController@index');
        //修改配置
        Route::post('config', 'ConfigController@upConfig');
        //便签管理
        Route::resource('note', 'NoteController', ['except' => ['create', 'show']]);
    });
});

Route::group(['namespace' => 'Home'], function () {
    Route::get('/', 'ArticleController@index');
    Route::get('sitemap.xml', 'SiteMapController@getSiteMap');
    Route::get('{slug}', 'ArticleController@show');
    Route::group(['prefix' => 'category'], function () {
        Route::get('/{id}', 'ArticleController@category');
    });
    Route::group(['prefix' => 'tag'], function () {
        Route::get('/{id}', 'ArticleController@tag');
    });
    Route::group(['prefix' => 'home'], function () {
        Route::post('comment', 'CommentController@store');
        Route::get('search', 'ArticleController@search');
    });
});

Route::group(['namespace' => 'Auth', 'prefix' => 'dd'], function () {
    // 重定向
    Route::get('/{service}', 'OAuthController@redirectToProvider');
    // 获取用户资料并登录
    Route::get('callback/{service}', 'OAuthController@handleProviderCallback');
    // 退出登录
    Route::get('/home/logout', 'OAuthController@logout');
    //检测登录
    Route::get('/home/check', 'OAuthController@checkLog');
});


