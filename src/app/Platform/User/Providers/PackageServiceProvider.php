<?php
namespace GLC\Platform\User\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use GLC\Platform\Database\Contracts\AssignIdRepository as AssignIdRepositoryContract;
use GLC\Platform\User\Contracts\UserRepository as UserRepositoryContract;
use GLC\Platform\User\Repositories\UserRepository;
use GLC\Platform\User\ViewModels\UserViewModel;

/**
 * Userパッケージを使用するのに必要な処理を行うプロバイダークラス。
 *
 * @package GLC\Platform\User\Providers
 * @author  Odo Ari <flasanpal@yahoo.co.jp>
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
        // UserRepository
        $this->app->bind(UserRepositoryContract::class, function() {
            $repository = new UserRepository($this->app->make(AssignIdRepositoryContract::class));
            $repository->setViewModel(new UserViewModel());
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
            UserRepositoryContract::class,
        ];
    }
}