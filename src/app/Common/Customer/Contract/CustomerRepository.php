<?php

namespace App\Common\Customer\Contract;

use App\Common\Customer\Model\Customer;
use App\Common\Database\Contract\ModelRepository;

/**
 * Customerモデルのデータ操作を扱うクラスを表すインターフェイス。
 * @package \App\Common\Customer
 */
interface CustomerRepository extends ModelRepository
{
    /**
     * 単一のユーザー情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\Customer\Model\Customer
     * @throws \Throwable
     */
    public function store(array $params): Customer;

    /**
     * 単一のユーザー情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\Customer\Model\Customer $customer
     * @return void
     * @throws \Throwable
     */
    public function update(Customer $customer, array $params): void;

    /**
     * 単一のユーザー情報を削除する。
     * @param  \App\Common\Customer\Model\Customer $customer
     * @return void
     * @throws \Throwable
     */
    public function delete(Customer $customer): void;

    /**
     * 最終ログイン日時を更新する。
     * ※ ログインにはメールアドレスを使用していて、ユニーク制約もあるのでIDに変換して検索はしていない。
     * @param  string $email
     * @return void
     */
    public function updateLastLoginDate(string $email): void;
}
