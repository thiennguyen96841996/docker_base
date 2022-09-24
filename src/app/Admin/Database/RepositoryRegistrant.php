<?php
namespace App\Admin\Database;

use App\Common\Database\Contract\RepositoryRegistrant as RepositoryRegistrantContract;

/**
 * 各環境毎のリポジトリーを登録するクラス。
 * @package \App\Admin\Database
 */
class RepositoryRegistrant implements RepositoryRegistrantContract
{
    /**
     * 使用するリポジトリーの定義。
     * @var array<class-string, class-string>
     */
    private array $repositories = [
        \App\Common\AdminUser\Contract\AdminUserRepository::class  => \App\Common\AdminUser\Repository\AdminUserRepository::class,
        \App\Common\ClientUser\Contract\ClientUserRepository::class => \App\Common\ClientUser\Repository\ClientUserRepository::class,
    ];

    /**
     * リポジトリーを登録する。
     * @return void
     */
    public function registerRepositories(): void
    {
        foreach ($this->repositories as $abstract => $concrete) {
            app()->bind($abstract, $concrete);
        }

        // コンストラクタに何らかの値を渡す必要がある場合は個別に定義する。
        //$this->registerXxxRepository();
        //$this->registerYyyRepository();
        //$this->registerZzzRepository();
    }
}
