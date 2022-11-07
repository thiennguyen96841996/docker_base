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

Route::middleware('guest')->name('admin.')->group(function () {
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Login
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\Auth\Controller')->group(function () {
        Route::get('/login', 'LoginController@index')->name('login.index');
        Route::post('/login', 'LoginController@login')->name('login.login');
    });
});
//----------------------------------
// 認証が必要なルーティング
//----------------------------------
Route::middleware('auth')->name('admin.')->group(function () {
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Logout
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\Auth\Controller')->group(function () {
        Route::get('/logout', 'LoginController@logout')->name('logout.logout');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Home
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\Home\Controller')->group(function () {
        Route::get('/', 'HomeController@index')->name('home.index');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Agency
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\Agency\Controller')->group(function () {
        Route::resource('agency', 'AgencyController');
        Route::post('agency/create', 'AgencyController@create')->name('agency.create');
        Route::put('agency/{agency}/edit', 'AgencyController@edit')->name('agency.edit');
        Route::match(['get', 'post'], 'agency/create/confirm', 'AgencyController@createConfirm')->name('agency.createConfirm');
        Route::match(['get', 'post', 'put'], 'agency/{agency}/edit/confirm', 'AgencyController@updateConfirm')->name('agency.updateConfirm');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Client
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\ClientUser\Controller')->group(function () {
        Route::resource('client-user', 'ClientUserController');
        Route::post('client-user/create', 'ClientUserController@create')->name('client-user.create');
        Route::put('client-user/{clientUser}/edit', 'ClientUserController@edit')->name('client-user.edit');
        Route::match(['get', 'post'], 'client-user/create/confirm', 'ClientUserController@createConfirm')->name('client-user.createConfirm');
        Route::match(['get', 'post', 'put'], 'client-user/{clientUser}/edit/confirm', 'ClientUserController@updateConfirm')->name('client-user.updateConfirm');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Post
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\Post\Controller')->group(function () {
        Route::resource('post', 'PostController')->except('create', 'store');
        Route::put('post/{post}/edit', 'PostController@edit')->name('post.edit');
        Route::match(['get', 'post', 'put'], 'post/{post}/edit/confirm', 'PostController@updateConfirm')->name('post.updateConfirm');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Customer
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\CustomerUser\Controller')->group(function () {
        Route::resource('customer-user', 'CustomerUserController');
        Route::put('customer-user/{customerUser}/edit', 'CustomerUserController@edit')->name('customer-user.edit');
        Route::match(['get', 'post', 'put'], 'customer-user/{customerUser}/edit/confirm', 'CustomerUserController@editConfirm')->name('customer-user.editConfirm');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Sample
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\Sample\Controller')->prefix('sample')->group(function () {
        Route::get('/page1', 'SampleController@index')->name('sample.index.1');
        Route::get('/page2', 'SampleController@index')->name('sample.index.2');
        Route::get('/page3', 'SampleController@index')->name('sample.index.3');
        Route::get('/page4', 'SampleController@index')->name('sample.index.4');
        Route::get('/page5', 'SampleController@index')->name('sample.index.5');
    });
});
