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
Route::middleware('guest')->name('admin.')->group(function() {
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
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Client
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Admin\ClientUser\Controller')->group(function () {
        Route::resource('clientUser', 'ClientUserController');
        Route::post('clientUser/create', 'ClientUserController@create')->name('clientUser.create');
        Route::put('clientUser/{clientUser}/edit', 'ClientUserController@edit')->name('clientUser.edit');
        Route::match(['get', 'post'], 'clientUser/create/confirm', 'ClientUserController@createConfirm')->name('clientUser.createConfirm');
        Route::match(['get', 'post', 'put'], 'clientUser/{clientUser}/edit/confirm', 'ClientUserController@editConfirm')->name('clientUser.editConfirm');
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
