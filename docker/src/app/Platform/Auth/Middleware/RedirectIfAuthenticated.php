<?php
namespace GLC\Platform\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GLC\Platform\User\Definitions\UserDefs;

/**
 * 認証状態をチェックする為のミドルウェアクラス。
 *
 * @package GLC\Platform\Auth\Middleware
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class RedirectIfAuthenticated
{
    /**
     * 認証状態をチェックする。
     * ※ 認証済みの場合、指定されたURLにリダイレクトする。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Closure $next 次のMiddlewareの処理
     * @param  string|null ...$guards Guardを実装したオブジェクトの識別名
     * @return \Illuminate\Http\RedirectResponse|\Closure RedirectResponseオブジェクト or 次のMiddlewareの処理
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (Auth::user() && Auth::user()->role === UserDefs::ROLE_CODE_AGENT) {
                    return redirect(route(config('auth.routes.name.authenticated_role_agent', '/')));
                }
                return redirect(route(config('auth.routes.name.authenticated', '/')));
            }
        }

        return $next($request);
    }
}