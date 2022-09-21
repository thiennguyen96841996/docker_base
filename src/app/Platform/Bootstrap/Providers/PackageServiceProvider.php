<?php
namespace GLC\Platform\Bootstrap\Providers;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use GLC\Platform\Bootstrap\Definitions\BootstrapDefs;
use GLC\Platform\Bootstrap\Contracts\Bootstrap as BootstrapContract;
/**
 * プラットフォーム上で動作するアプリケーションの起動処理を行うプロバイダークラス。
 *
 * @package GLC\Platform\Bootstrap\Providers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class PackageServiceProvider extends ServiceProvider
{
    /**
     * アプリケーションに合わせた起動処理を行うクラスを保持する変数。
     * @var \GLC\Platform\Bootstrap\Contracts\Bootstrap|null
     */
    private ?BootstrapContract $bootstrap;
    /**
     * サービスの登録処理を行う。
     *
     * @return void
     * @throws Exception
     */
    public function register()
    {
        if (!empty($namespace = $this->detectApplication())) {
            if (class_exists($class = "\\GLC\\{$namespace}\\Bootstrap\Bootstrap")
                && is_subclass_of($class, BootstrapContract::class))
            {
                $this->bootstrap = new $class($this->app);
                $this->bootstrap->register();
            }
        } else {
            throw new Exception('Cannot load Bootstrap class.');
        }
    }

    /**
     * サービスの起動処理を行う。
     *
     * @return void
     */
    public function boot()
    {
        if (!is_null($this->bootstrap)) {
            $this->bootstrap->boot();
        }
    }

    /**
     * 起動時のコールバック処理を行う。
     *
     * @return void
     */
    public function callBootingCallbacks()
    {
        $this->bootstrap->callBootingCallbacks();
    }

    /**
     * 起動後のコールバック処理を行う。
     *
     * @return void
     */
    public function callBootedCallbacks()
    {
        $this->bootstrap->callBootedCallbacks();
    }

    /**
     * アプリケーションを特定する。
     * ※ まだModelクラスを通じたアクセスが出来ないのでPDOを直接使用してデータを取得する。
     *
     * @return string|null
     * @throws Exception
     */
    private function detectApplication(): ?string
    {
        // コンソール実行はMasterの処理として扱う。
        if ($this->app->runningInConsole()) {
            $this->updateConfigurations(config('app.batch_url'), config('app.batch_name'));
            return BootstrapDefs::BOOT_TYPE_BATCH;
        } else {
            switch (request()->getHost()) {
                // Master
                case config('app.tool_url'):
                    $this->updateConfigurations(config('app.tool_url'), config('app.tool_name'));
                    return BootstrapDefs::BOOT_TYPE_MASTER;
                //Customer
                case config('app.customer_url'):
                    $this->updateConfigurations(config('app.customer_url'), config('app.customer_name'));
                    return BootstrapDefs::BOOT_TYPE_CUSTOMER;
                //Client
                case config('app.client_url'):
                    $this->updateConfigurations(config('app.client_url'), config('app.client_name'));
                    return BootstrapDefs::BOOT_TYPE_CLIENT;
                //API
                case config('app.api_url'):
                    $this->updateConfigurations(config('app.api_url'), config('app.api_name'));
                    return BootstrapDefs::BOOT_TYPE_API;
                //Secure API
                case config('app.secure_api_url'):
                    $this->updateConfigurations(config('app.secure_api_url'), config('app.secure_api_name'));
                    return BootstrapDefs::BOOT_TYPE_SECURE_API;
            }
            throw new Exception('Cannot detect boot type. Please check your .env !');
        }
    }

    /**
     * サイトに応じて設定を変更する。
     *
     * @param  string $domain ドメイン
     * @param  string $name サービス名称
     * @return void
     */
    private function updateConfigurations(string $domain, string $name)
    {
        Config::set([
            'app.url'           => $domain,
            'session.domain'    => $domain,
            'session.cookie'    => str_replace('.', '_', $domain) . '_ssn',
            'cache.prefix'      => str_replace('.', '_', $domain) . '_cache',
            'mail.from.address' => env('MAIL_FROM_ADDRESS'),
            'mail.from.name'    => $name,
        ]);
    }
}
