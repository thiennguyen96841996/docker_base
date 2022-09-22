<?php
namespace GLC\Platform\Photo\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use GLC\Platform\Photo\Contracts\PhotoRepository as PhotoRepositoryContract;
use GLC\Platform\Photo\Repositories\PhotoRepository;

/**
 * Photoパッケージを使用するのに必要な処理を行うプロバイダークラス。
 *
 * @package GLC\Platform\Photo\Providers
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
        // PhotoRepository
        $this->app->bind(PhotoRepositoryContract::class, function() {
            $repository = new PhotoRepository();
            return $repository;
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
            PhotoRepositoryContract::class,
        ];
    }
}