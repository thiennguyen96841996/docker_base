<?php
namespace App\Customer\Database;

use App\Common\Database\Contract\RepositoryRegistrant as RepositoryRegistrantContract;

/**
 * 各環境毎のリポジトリーを登録するクラス。
 * @package \App\Customer\Database
 */
class RepositoryRegistrant implements RepositoryRegistrantContract
{
    /**
     * 使用するリポジトリーの定義。
     * @var array<class-string, class-string>
     */
    private array $repositories = [
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
