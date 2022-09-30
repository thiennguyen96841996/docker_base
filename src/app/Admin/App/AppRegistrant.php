<?php
namespace App\Admin\App;

use App\Common\AdminUser\Service\AdminUserService as AdminUserServiceProvider;
use App\Common\App\Contract\AppRegistrant as AppRegistrantContract;
use App\Common\Sample\Provider\ServiceProvider as SampleServiceProvider;
use App\Common\Agency\Provider\ServiceProvider as AgencyServiceProvider;
use App\Common\ClientUser\Provider\ServiceProvider as ClientUserServiceProvider;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

/**
 * 環境固有で必要なモジュールを登録するクラス。
 * @package \App\Admin\App
 */
class AppRegistrant implements AppRegistrantContract
{
    /**
     * Applicationオブジェクトを保持する変数。
     * @var ApplicationContract
     */
    private ApplicationContract $app;

    /**
     * アプリケーションで使用するプロバイダーの定義。
     * Common側のServiceProviderを先に指定して起動する。
     * @var array
     */
    private $providers = [
        SampleServiceProvider::class,
        AgencyServiceProvider::class,
        ClientUserServiceProvider::class
    ];

    /**
     * Bootstrap constructor.
     *
     * @param ApplicationContract $app Applicationを実装したオブジェクト
     */
    public function __construct(ApplicationContract $app)
    {
        $this->app = $app;
    }

    /**
     * 環境固有で必要なモジュールを登録する。
     * @return void
     */
    public function register(): void
    {
        $this->registerApplicationProviders();

        Validator::extend('tel',      '\App\Common\Validation\TelValidator@validateTel');
    }


    /**
     * 起動処理を行う。
     *
     * @return void
     */
    public function boot()
    {
        $this->bootApplicationProviders();

        // Debugbarは使用しない
        if (class_exists('Barryvdh\Debugbar\Facade')) {
            app('debugbar')->disable();
        }

        //(new \App\Common\Database\QueryDebugger())->setup();
    }

    /**
     * アプリケーションで使用するプロバイダーの起動処理を行う。
     *
     * @return void
     */
    private function bootApplicationProviders()
    {
        foreach ($this->providers as $provider) {
            if ($provider instanceof ServiceProvider) {
                if (method_exists($provider, 'boot')) {
                    $provider->boot();
                }
            } else {
                Log::channel('error')->error('$provider is not service provider.');
            }
        }
    }


    /**
     * アプリケーションで使用するプロバイダーをコンテナに登録する。
     *
     * @return void
     */
    private function registerApplicationProviders()
    {
        foreach ($this->providers as $position => $provider) {
            /** @var \Illuminate\Support\ServiceProvider $instance */
            $instance = new $provider($this->app);
            $instance->register();

            $this->providers[$position] = $instance;
        }
    }
}
