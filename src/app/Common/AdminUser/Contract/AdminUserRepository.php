<?php
namespace App\Common\AdminUser\Contract;

use App\Common\AdminUser\Model\AdminUser;
use App\Common\Database\Contract\ModelRepository;

/**
 * AdminUserモデルのデータ操作を扱うクラスを表すインターフェイス。
 * @package \App\Common\AdminUser
 */
interface AdminUserRepository extends ModelRepository
{
    /**
     * 単一の管理ユーザー情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\AdminUser\Model\AdminUser
     * @throws \Throwable
     */
    public function store(array $params): AdminUser;

    /**
     * 単一の管理ユーザー情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\AdminUser\Model\AdminUser $adminUser
     * @return void
     * @throws \Throwable
     */
    public function update(AdminUser $adminUser, array $params): void;

    /**
     * 単一の管理ユーザー情報を削除する。
     * @param  \App\Common\AdminUser\Model\AdminUser $adminUser
     * @return void
     * @throws \Throwable
     */
    public function delete(AdminUser $adminUser): void;

    /**
     * 最終ログイン日時を更新する。
     * ※ ログインにはメールアドレスを使用していて、ユニーク制約もあるのでIDに変換して検索はしていない。
     * @param  string $email
     * @return void
     */
    public function updateLastLoginDate(string $email): void;
}
