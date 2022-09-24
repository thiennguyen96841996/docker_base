<?php
namespace App\Common\Auth\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

/**
 * 認証状態をチェックするミドルウェア。
 * @package \App\Common\Auth
 */
class Authenticate extends Middleware
{
    /**
     * 未認証だった場合にリダイレクトするパスを取得する。
     * @param  \Illuminate\Http\Request $request
     * @return string|null 名前付きルートのURL
     * @noinspection PhpMissingReturnTypeInspection
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route(config('auth.guest_route_name','login'));
        }
        return null;
    }
}
