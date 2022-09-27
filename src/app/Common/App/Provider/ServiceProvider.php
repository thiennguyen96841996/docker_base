<?php
namespace App\Common\App\Provider;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\App\Contract\AppRegistrant as AppRegistrantContract;
use App\Common\Database\QueryDebugger;

/**
 * プロジェクト全体に関わるサービスの登録や設定を行うクラス。
 * @package \App\Common\App
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * サービスを登録する。
     * @return void
     */
    public function register()
    {
        if (!$this->app->isProduction()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * サービスを起動する。
     * @return void
     */
    public function boot()
    {
        QueryDebugger::setup();

        // 環境毎のモジュールを読み込む
        if (!empty($class = config('speedy.app_registrant'))) {
            if (!class_exists($class)) {
                Log::error('AppRegistrant class is not found. [class]:'.$class);
                return;
            }
            /** @var AppRegistrantContract $instance */
            $instance = new $class($this->app);

            if (!is_subclass_of($class, AppRegistrantContract::class)) {
                Log::error('AppRegistrant class is not implement contract.');
                return;
            }
            $instance->register();
        }
    }
}
