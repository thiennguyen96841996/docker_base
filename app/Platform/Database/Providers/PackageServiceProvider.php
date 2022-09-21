<?php
namespace GLC\Platform\Database\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use GLC\Platform\Database\Contracts\AssignIdRepository as AssignIdRepositoryContract;
use GLC\Platform\Database\Repositories\AssignIdRepository;

/**
 * Databaseパッケージを使用するのに必要な処理を行うプロバイダークラス。
 *
 * @package GLC\Platform\Database\Providers
 * @author  TinhNC <tinhhang22@gmail.com>
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
        // AssignIdRepository
        $this->app->bind(AssignIdRepositoryContract::class, function() {
            return new AssignIdRepository();
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
            AssignIdRepositoryContract::class,
        ];
    }
}