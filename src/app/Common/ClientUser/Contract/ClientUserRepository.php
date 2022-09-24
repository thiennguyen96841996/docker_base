<?php
namespace App\Common\ClientUser\Contract;

use App\Common\ClientUser\Model\ClientUser;
use App\Common\Database\Contract\ModelRepository;

/**
 * ClientUserモデルのデータ操作を扱うクラスを表すインターフェイス。
 * @package \App\Common\ClientUser
 */
interface ClientUserRepository extends ModelRepository
{
    /**
     * 単一の企業ユーザー情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\ClientUser\Model\ClientUser
     * @throws \Throwable
     */
    public function store(array $params): ClientUser;

    /**
     * 単一の企業ユーザー情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\ClientUser\Model\ClientUser $clientUser
     * @return void
     * @throws \Throwable
     */
    public function update(ClientUser $clientUser, array $params): void;

    /**
     * 単一の企業ユーザー情報を削除する。
     * @param  \App\Common\ClientUser\Model\ClientUser $clientUser
     * @return void
     * @throws \Throwable
     */
    public function delete(ClientUser $clientUser): void;

    /**
     * 最終ログイン日時を更新する。
     * ※ ログインにはメールアドレスを使用していて、ユニーク制約もあるのでIDに変換して検索はしていない。
     * @param  string $email
     * @return void
     */
    public function updateLastLoginDate(string $email): void;
}
