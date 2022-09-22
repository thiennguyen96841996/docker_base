<?php

namespace GLC\Platform\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiAccessRequestLog
{

    /**
     * APIにアクセスする度にリクエストの情報をログに残しておく
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $path = $request->path();
        $platform = $request->header('platform');
        $deviceName = $request->header('device-name');
        $osVersion = $request->header('os-version');
        $appVersion = $request->header('app-version');
        $customerId = $request->header('customer-id');

        Log::channel('apiAccessRequest')->info("PATH: {$path}, PLATFORM: {$platform}, DEVICE_NAME: {$deviceName}, OS_VERSION: {$osVersion}, APP_VERSION: {$appVersion}, CUSTOMER_ID: {$customerId}");

        return $next($request);
    }
}