<?php
namespace GLC\Master\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GLC\Platform\User\Definitions\UserDefs;

/**
 * パスワードの変更状態をチェックするミドルウェアクラス。
 *
 * @package GLC\Master\Auth\Middleware
 */
class CheckRole
{
    /**
     * パスワードの変更状態をチェックする。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Closure $next 次のMiddlewareの処理
     * @param  string|null ...$guards Guardを実装したオブジェクトの識別名
     * @return \Illuminate\Http\RedirectResponse|\Closure RedirectResponseオブジェクト or 次のMiddlewareの処理
     */
    public function handle(Request $request, Closure $next, $auth)
    {
        if (!$this->has($auth)) {
            return back()->withErrors( '権限がありません。');
        }
        return $next($request);
    }

    public function has($auth): bool
    {
        return in_array($auth, UserDefs::getRole(Auth::user()->role));
    }
}