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
Route::name('customer.')->group(function () {
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Home
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Customer\Home\Controller')->group(function () {
        Route::get('/', 'HomeController@index')->name('home.index');
    });
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Sample
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    Route::namespace('App\Customer\Sample\Controller')->prefix('sample')->group(function () {
        Route::get('/page1', 'SampleController@index')->name('sample.index.1');
        Route::get('/page2', 'SampleController@index')->name('sample.index.2');
        Route::get('/page3', 'SampleController@index')->name('sample.index.3');
        Route::get('/page4', 'SampleController@index')->name('sample.index.4');
        Route::get('/page5', 'SampleController@index')->name('sample.index.5');
    });
});
