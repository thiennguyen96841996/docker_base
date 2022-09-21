<?php
namespace GLC\Client\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GLC\Platform\Auth\Definitions\AuthDefs;

/**
 * パスワードの変更状態をチェックするミドルウェアクラス。
 *
 * @package GLC\Master\Auth\Middleware
 */
class CheckAcceptedRegulation
{
    /**
     * パスワードの変更状態をチェックする。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Closure $next 次のMiddlewareの処理
     * @param  string|null ...$guards Guardを実装したオブ1ジェクトの識別名
     * @return \Illuminate\Http\RedirectResponse|\Closure RedirectResponseオブジェクト or 次のMiddlewareの処理
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        //TODO:リファクタリング検討
        //データをBIT化
        $bit = str_pad(
            decbin(Auth::user()->navigation),
            AuthDefs::NAVIGATION_ACTIVE_DIGIT,
            0,
            STR_PAD_LEFT
        );

        //規約同意の定義BIT
        $comp = AuthDefs::getNavigationBitNumber();

        if (($bit & $comp) !== $comp) {
            return redirect(route('client.regulation.index'))
                ->withErrors('規約の同意をしてください');
        }
        return $next($request);
    }
}