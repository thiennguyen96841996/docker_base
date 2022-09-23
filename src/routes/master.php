<?php
use Illuminate\Support\Facades\Route;


Route::group([ 'domain' => config('app.tool_url') ], function() {
    Route::get('/', [
        'as' => 'master.sample.index',
        'uses' => 'GLC\Master\SampleFunction\Controllers\SampleController@index'
    ]);
});
