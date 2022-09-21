<?php
namespace GLC\Platform\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

/**
 * アプリケーション全体に関わるHTTP(S)リクエストの管理クラス。
 *
 * @package GLC\Platform\Http
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class Kernel extends HttpKernel
{
    /**
     * アプリケーションへの全てのHTTP(S)リクエストで実行するミドルウェアの定義。
     * @var array
     */
    protected $middleware = [
        \GLC\Platform\Http\Middleware\TrustHosts::class,
//        \Fideloper\Proxy\TrustProxies::class,
        \GLC\Platform\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \GLC\Platform\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \GLC\Platform\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \GLC\Platform\Http\Middleware\NormalizeCrlf::class,
        \GLC\Platform\Http\Middleware\Timestamp::class,
    ];

    /**
     * アプリケーションのルート毎に実行するミドルウェアの定義。
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \GLC\Platform\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            //\Illuminate\Session\Middleware\AuthenticateSession::class,
            \GLC\Platform\View\Middleware\ShareErrorsFromSession::class,
            \GLC\Platform\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
//            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \GLC\Platform\Http\Middleware\ApiAccessRequestLog::class,
        ],
    ];

    /**
     * 全ルートに適用するのではなく、特定のルートに個別で適用させたいミドルウェアの定義。
     * @var array
     */
    protected $routeMiddleware = [
        'auth'             => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers'    => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can'              => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'            => \GLC\Platform\Auth\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed'           => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle'         => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'         => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'oauth'            => \GLC\Platform\Http\Middleware\CheckAccessToken::class,
    ];
}