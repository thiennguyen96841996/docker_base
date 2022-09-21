<?php
namespace GLC\Platform\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Route;

/**
 * 実行速度をログに落とすミドルウェアクラス。
 *
 * @package GLC\Platform\Http\Middleware
 */
class Timestamp
{
    /**
     * リクエストの入力に含まれる改行文字の値を"\n"に正規化する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Closure $next 次のMiddlewareの処理
     * @return \Illuminate\Http\RedirectResponse|\Closure RedirectResponseオブジェクト or 次のMiddlewareの処理
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $routeName = Route::currentRouteName();

        $log = [
            Carbon::now()->format('Y-m-d H:i:s'),
            $response->getStatusCode(),
            ! empty($routeName) ? $routeName : '__blank__',
            \Illuminate\Support\Facades\Request::url(),
            microtime(true) - LARAVEL_START,
        ];

        Log::channel('statistic')->info(implode(',', $log));

        return $response;
    }
}