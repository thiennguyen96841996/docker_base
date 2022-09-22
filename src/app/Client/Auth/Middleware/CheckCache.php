<?php
namespace GLC\Client\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * cacheに必要な情報が格納されているか確認するためのミドルウェアクラス。
 *
 * @package GLC\Master\Auth\Middleware
 */
class CheckCache
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param ...$guards
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (is_null(Auth::user()->active_id)) {
            return redirect(route('client.top.multi'))
                ->withErrors('利用する事業所を選択してください');
        }

        return $next($request);
    }
}