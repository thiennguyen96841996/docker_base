<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->name('client.')->group(function () {
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Login
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Client\Auth\Controller')->group(function () {
        Route::get('/login', 'LoginController@index')->name('login.index');
        Route::post('/login', 'LoginController@login')->name('login.login');
    });
});
//----------------------------------
// 認証が必要なルーティング
//----------------------------------
Route::middleware('auth')->name('client.')->group(function () {
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Logout
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Client\Auth\Controller')->group(function () {
        Route::get('/logout', 'LoginController@logout')->name('logout.logout');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Home
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Client\Home\Controller')->group(function () {
        Route::get('/', 'HomeController@index')->name('home.index');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // News
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Client\News\Controller')->group(function () {
        Route::resource('news', 'NewsController');
        Route::post('news/create/confirm', 'NewsController@createConfirm')->name('news.createConfirm');
        Route::match(['post', 'put'], 'news/{news}/edit/confirm', 'NewsController@updateConfirm')->name('news.updateConfirm');
    });
    // Post
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Client\Post\Controller')->group(function () {
        Route::resource('post', 'PostController');
        Route::post('post/create', 'PostController@create')->name('post.create');
        Route::put('post/{post}/edit', 'PostController@edit')->name('post.edit');
        Route::match(['get', 'post'],'post/create/confirm', 'PostController@createConfirm')->name('post.createConfirm');
        Route::match(['get', 'post', 'put'],'post/{post}/edit/confirm', 'PostController@updateConfirm')->name('post.updateConfirm');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Sample
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Client\Sample\Controller')->prefix('sample')->group(function () {
        Route::get('/page1', 'SampleController@index')->name('sample.index.1');
        Route::get('/page2', 'SampleController@index')->name('sample.index.2');
        Route::get('/page3', 'SampleController@index')->name('sample.index.3');
        Route::get('/page4', 'SampleController@index')->name('sample.index.4');
        Route::get('/page5', 'SampleController@index')->name('sample.index.5');
    });
});
