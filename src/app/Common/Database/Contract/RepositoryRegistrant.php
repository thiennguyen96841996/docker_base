<?php
namespace App\Common\Database\Contract;

/**
 * 各環境毎のリポジトリーを登録するクラスを表すインターフェイス。
 * @package \App\Common\Database
 */
interface RepositoryRegistrant
{
    /**
     * リポジトリーを登録する。
     * @return void
     */
    public function registerRepositories(): void;
}
