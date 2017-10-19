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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'dd','namespace'=>'\Admin'],function (){
    Route::get('login','LoginController@login')->name('dd.login');
    Route::get('reg','LoginController@reg');
    Route::get('check','LoginController@check');
    Route::post('login','LoginController@toLogin');

    Route::group(['middleware'=>'admincheck'],function (){
        Route::get('index','HomeController@index')->name('dd.index');
        Route::get('logout','LoginController@logout');
        Route::resource('category', 'CategoryController', ['except' => ['create', 'show']]);
        Route::resource('tag', 'tagController', ['except' => ['create', 'show']]);
    });

});


