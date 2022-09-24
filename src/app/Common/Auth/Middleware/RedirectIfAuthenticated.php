<?php
namespace App\Common\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 認証状態をチェックするミドルウェア。
 * @package \App\Common\Auth
 */
class RedirectIfAuthenticated
{
    /**
     * 認証状態をチェックする。
     * ※ 認証済みの場合、指定されたURLにリダイレクトする。
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next 次のミドルウェアの処理
     * @param  array $guards
     * @return \Illuminate\Http\RedirectResponse|\Closure
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(route(config('auth.authenticated_route_name','home')));
            }
        }
        return $next($request);
    }
}
