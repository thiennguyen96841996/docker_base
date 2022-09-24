<?php
namespace App\Common\Routing\Provider;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

/**
 * ルーティングの設定と登録を行うクラス。<br>
 * ※ config/App.phpにてroute_path/route_api_pathが指定されていない場合はどこにもルーティングされない。
 * @package \App\Common\Routing
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * サービスを起動する。
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            if (!empty($path = config('speedy.route_path'))) {
                Route::middleware('web')
                    ->group(base_path($path));
            }
//            if (!empty($apiPath = config('speedy.route_api_path'))) {
//                Route::middleware('api')
//                    ->prefix('api')
//                    ->group(base_path($apiPath));
//            }
        });
    }

    /**
     * レートリミットを設定する。
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::none();
//            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
