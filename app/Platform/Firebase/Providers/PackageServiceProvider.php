<?php
namespace GLC\Platform\Firebase\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use GLC\Platform\Firebase\Contracts\DeviceTokenRepository as DeviceTokenRepositoryContract;
use GLC\Platform\Firebase\Repositories\DeviceTokenRepository;

/**
 * Firebaseパッケージを使用するのに必要な処理を行うプロバイダークラス。
 *
 * @package GLC\Platform\Firebase\Providers
 */
class PackageServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * サービスの登録処理を行う。
     *
     * @return void
     */
    public function register()
    {
        // DeviceTokenRepository
        $this->app->bind(DeviceTokenRepositoryContract::class, function() {
            return new DeviceTokenRepository();
        });
    }

    /**
     * このクラスが提供するサービスの配列を返す。
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            DeviceTokenRepositoryContract::class,
        ];
    }
}