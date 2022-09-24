<?php
namespace App\Common\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

/**
 * アプリケーション全体のHTTP(S)リクエストを管理するクラス。
 * @package \App\Common\Http
 */
class Kernel extends HttpKernel
{
    /**
     * アプリケーションへの全てのHTTP(S)リクエストで実行するミドルウェアの定義。
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Common\Http\Middleware\TrustHosts::class,
        \App\Common\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Common\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \App\Common\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * アプリケーションのルート毎に実行するミドルウェアの定義。
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Common\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Common\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
             \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * 全ルートに適用するのではなく、特定のルートに個別で適用させたいミドルウェアの定義。
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth'             => \App\Common\Auth\Middleware\Authenticate::class,
        'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session'     => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers'    => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can'              => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'            => \App\Common\Auth\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed'           => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle'         => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'         => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
