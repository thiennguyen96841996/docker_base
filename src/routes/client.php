<?php
use Illuminate\Support\Facades\Route;
require base_path('routes/master.php');

Route::group([ 'domain' => config('app.client_url') ], function() {

});