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
    // Agency Contract
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\AgencyContract\Controller')->group(function () {
        Route::get('agency-contract', 'AgencyContractController@index')->name('agency-contract.index');
        Route::get('{agency_id}/agency-contract/{agency_contract}', 'AgencyContractController@show')->name('agency-contract.show')->where(['agency_contract' => '[1-9][0-9]{4,}']);
        Route::match(['get', 'post'],'{agency_id}/agency-contract/create', 'AgencyContractController@create')->name('agency-contract.create');
        Route::match(['get', 'post'], '{agency_id}/agency-contract/create/confirm', 'AgencyContractController@createConfirm')->name('agency-contract.createConfirm');
        Route::post('{agency_id}/agency-contract/store', 'AgencyContractController@store')->name('agency-contract.store');
        Route::delete('{agency_id}/agency-contract/{agency_contract}', 'AgencyContractController@destroy')->name('agency-contract.delete')->where(['agency_contract' => '[1-9][0-9]{4,}']);
        Route::match(['get', 'put'], '{agency_id}/agency-contract/{agency_contract}/cancel', 'AgencyContractController@cancel')->name('agency-contract.cancel')->where(['agency_contract' => '[1-9][0-9]{4,}']);
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Client
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\ClientUser\Controller')->group(function () {
        Route::resource('client-user', 'ClientUserController');
        Route::post('client-user/create', 'ClientUserController@create')->name('client-user.create');
        Route::put('client-user/{client_user}/edit', 'ClientUserController@edit')->name('client-user.edit');
        Route::match(['get', 'post'], 'client-user/create/confirm', 'ClientUserController@createConfirm')->name('client-user.createConfirm');
        Route::match(['get', 'post', 'put'], 'client-user/{client_user}/edit/confirm', 'ClientUserController@updateConfirm')->name('client-user.updateConfirm');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Post
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\Post\Controller')->group(function () {
        Route::resource('post', 'PostController')->only('index', 'show');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Customer
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\CustomerUser\Controller')->group(function () {
        Route::resource('customer-user', 'CustomerUserController')->except('create');
        Route::match(['post'], 'customer-user/{customer_user}/edit', 'CustomerUserController@edit')->name('customer-user.edit');
        Route::put('customer-user/{customer_user}/update-status', 'CustomerUserController@updateStatus')->name('customer-user.updateStatus');
        Route::match(['get', 'post', 'put'], 'customer-user/{customer_user}/edit/confirm', 'CustomerUserController@updateConfirm')->name('customer-user.updateConfirm');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Bookmark
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\BookmarkLink\Controller')->group(function () {
        Route::resource('bookmark', 'BookmarkLinkController')->only('index', 'store', 'destroy');
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
