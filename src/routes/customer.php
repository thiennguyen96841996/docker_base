<?php
use Illuminate\Support\Facades\Route;
//require base_path('routes/client.php');

Route::group([ 'domain' => config('app.customer_url') ], function() {

});
