<?php
namespace GLC\Api\Bootstrap;

use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use GLC\Api\Console\Providers\ConsoleServiceProvider;
use GLC\Api\Exception\Providers\ExceptionServiceProvider;
use GLC\Api\Auth\Providers\AuthServiceProvider;
use GLC\Api\Routing\Providers\RouteServiceProvider;
use GLC\Platform\Bootstrap\Contracts\Bootstrap as BootstrapContract;
use GLC\Platform\Sms\Providers\PackageServiceProvider as SmsServiceProvider;
use GLC\Platform\Firebase\Providers\PackageServiceProvider as FirebaseServiceProvider;

/**
 * アプリケーションに合わせた起動処理を行うクラス。
 *
 * @package GLC\Api\Bootstrap
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class Bootstrap implements BootstrapContract
{
    /**
     * Applicationオブジェクトを保持する変数。
     * @var ApplicationContract
     */
    private ApplicationContract $app;

    /**
     * アプリケーションで使用するプロバイダーの定義。
     * ※ Platform側のProviderを先に指定して起動する。
     * @var array
     */
    private $providers = [
        ExceptionServiceProvider::class,
        ConsoleServiceProvider::class,
        RouteServiceProvider::class,
        SmsServiceProvider::class,
        AuthServiceProvider::class,
        FirebaseServiceProvider::class,
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
     * 登録処理を行う。
     *
     * @return void
     */
    public function register()
    {
        $this->registerApplicationProviders();
        $this->registerRouteMiddleware();
    }

    /**
     * 起動処理を行う。
     *
     * @return void
     */
    public function boot()
    {
        $this->bootApplicationProviders();

        Validator::extend('katakana', '\GLC\Platform\Validation\KatakanaValidator@validateKatakana');
        Validator::extend('tel',      '\GLC\Platform\Validation\TelValidator@validateTel');

        // Debugbarは使用しない
        if (class_exists('Barryvdh\Debugbar\Facade')) {
            app('debugbar')->disable();
        }

        //(new \GLC\Platform\Database\QueryDebugger())->setup();
    }

    /**
     * 起動時のコールバック処理を行う。
     *
     * @return void
     */
    public function callBootingCallbacks()
    {
        foreach ($this->providers as $provider) {
            if ($provider instanceof ServiceProvider) {
                if (method_exists($provider, 'callBootingCallbacks')) {
                    $provider->callBootingCallbacks();
                }
            } else {
                Log::channel('error')->error('$provider is not service provider.');
            }
        }
    }

    /**
     * 起動後のコールバック処理を行う。
     *
     * @return void
     */
    public function callBootedCallbacks()
    {
        foreach ($this->providers as $provider) {
            if ($provider instanceof ServiceProvider) {
                if (method_exists($provider, 'callBootedCallbacks')) {
                    $provider->callBootedCallbacks();
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
     * アプリケーションに必要なRouteMiddlewareを登録する。
     *
     * 以下のようなフォーマットでkernelの$routeMiddlewareと同じように記述する。
     * Route::aliasMiddleware('middleware', \GLC\Api\Middleware\Middleware::class);
     *
     * @return void
     */
    private function registerRouteMiddleware()
    {
    }
}