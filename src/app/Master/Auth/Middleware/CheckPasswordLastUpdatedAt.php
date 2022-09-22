<?php
namespace GLC\Master\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * パスワードの変更状態をチェックするミドルウェアクラス。
 *
 * @package GLC\Master\Auth\Middleware
 */
class CheckPasswordLastUpdatedAt
{
    /**
     * パスワードの変更状態をチェックする。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Closure $next 次のMiddlewareの処理
     * @param  string|null ...$guards Guardを実装したオブジェクトの識別名
     * @return \Illuminate\Http\RedirectResponse|\Closure RedirectResponseオブジェクト or 次のMiddlewareの処理
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        /** @var \GLC\Platform\Auth\Models\AuthUser $user */
        if (is_null($user = Auth::user()) || is_null($user->last_password_updated_at)) {
            return redirect(route('master.password.index'))
                ->withErrors('パスワードを変更してください');
        }
        return $next($request);
    }
}