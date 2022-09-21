<?php
namespace GLC\Api\Routing\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

/**
 * ルーティングに関連する設定を行うプロバイダークラス。
 *
 * @package GLC\Api\Routing\Providers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * サービスの起動処理を行う。
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            Route::domain(config('app.api_url'))
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }

}