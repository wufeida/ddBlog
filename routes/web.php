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
    Route::get('reg','LoginController@reg');
    Route::get('check','LoginController@check');
    Route::post('login','LoginController@toLogin');

    Route::group(['middleware'=>'admincheck'],function (){
        Route::get('index','HomeController@index')->name('dd.index');
        Route::get('cache','HomeController@cache');
        Route::get('logout','LoginController@logout');
        Route::resource('category', 'CategoryController', ['except' => ['create', 'show']]);
        Route::resource('tag', 'TagController', ['except' => ['create', 'show']]);
        Route::resource('article', 'ArticleController', ['except' => ['show']]);
        Route::get('recommend', 'ArticleController@recommend');
        Route::post('recommend/{id}', 'ArticleController@isRecommend');
        Route::post('sort', 'ArticleController@sort');
        Route::resource('link', 'LinkController', ['except' => ['create', 'show']]);
        Route::get('visitor','VisitorController@index');
        Route::resource('comment', 'CommentController', ['except' => ['create', 'show']]);
        Route::get('trash', 'TrashController@index');
        Route::get('del/{type}/{id}', 'TrashController@onlyDel');
        Route::get('empty', 'TrashController@allDel');
        Route::get('undo/{type}/{id}', 'TrashController@undo');
        Route::get('undo/all', 'TrashController@undoAll');
        Route::get('file', 'FileController@index');
        Route::get('file/delete', 'FileController@deleteFile');
        Route::post('folder', 'FileController@createFolder');
        Route::delete('folder', 'FileController@deleteFolder');
        Route::post('upload', 'FileController@uploadForManager');
        Route::post('file/upload', 'FileController@fileUpload');
    });
});

Route::group(['namespace' => 'Home'], function () {
    Route::get('/', 'ArticleController@index');
    Route::get('{slug}', 'ArticleController@show');
    Route::group(['prefix' => 'category'], function () {
        Route::get('/{id}', 'ArticleController@category');
    });
    Route::group(['prefix' => 'tag'], function () {
        Route::get('/{id}', 'ArticleController@tag');
    });
    Route::group(['prefix' => 'home'], function () {
        Route::post('comment', 'CommentController@store');
    });
});

Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
    // 重定向
    Route::get('/{service}', 'OAuthController@redirectToProvider');
    // 获取用户资料并登录
    Route::get('callback/{service}', 'OAuthController@handleProviderCallback');
    // 退出登录
    Route::get('/home/logout', 'OAuthController@logout');
});


