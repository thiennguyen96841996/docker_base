<?php
namespace GLC\Customer\Bootstrap;

use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use GLC\Customer\Exception\Providers\ExceptionServiceProvider;
use GLC\Customer\Routing\Providers\RouteServiceProvider;
use GLC\Platform\Bootstrap\Contracts\Bootstrap as BootstrapContract;
use GLC\Platform\Database\Providers\PackageServiceProvider as DatabaseServiceProvider;
use GLC\Platform\View\Providers\PackageServiceProvider as ViewServiceProvider;

/**
 * アプリケーションに合わせた起動処理を行うクラス。
 *
 * @package GLC\Master\Bootstrap
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
        RouteServiceProvider::class,
        ViewServiceProvider::class,
        DatabaseServiceProvider::class,
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

        Validator::extend('password', '\GLC\Platform\Validation\PasswordValidator@validatePassword');
        Validator::extend('katakana', '\GLC\Platform\Validation\KatakanaValidator@validateKatakana');
        Validator::extend('tel',      '\GLC\Platform\Validation\TelValidator@validateTel');
        Validator::extend('gp_email', '\GLC\Platform\Validation\GalapagosEmailValidator@validateGalapagosEmail');
        Validator::extend('no_space', '\GLC\Platform\Validation\SpaceValidator@validateNoSpace');
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
     * Route::aliasMiddleware('middleware', \GLC\Master\Middleware\Middleware::class);
     *
     * @return void
     */
    private function registerRouteMiddleware()
    {
    }
}