<?php

namespace App\Common\Customer\Repository;

use App\Common\Customer\Contract\CustomerRepository as CustomerRepositoryContract;
use App\Common\Customer\Model\Customer;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;
use App\Common\Database\MysqlCryptorTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Common\Database\RepositoryConnection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\Database\Definition\DatabaseDefs;
use Illuminate\Support\Facades\Hash;

/**
 * Customerモデルのデータ操作を扱うクラス。
 * @package \App\Common\Customer
 */
class CustomerRepository implements CustomerRepositoryContract
{
    use RepositoryConnection, MysqlCryptorTrait;

    /**
     * 検索条件に合致したデータを持つCustomerモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAll(array $searchConditions, array $selectColumns = ['*']): Collection
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->get();
    }

    /**
     * 検索条件に合致したデータを持つCustomerモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function fetchAsPaginator(array $searchConditions, array $selectColumns = ['*']): LengthAwarePaginator
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->paginate();
    }

    /**
     * 検索条件に合致した単一のCustomerモデルを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \App\Common\Customer\Model\Customer
     * @throws \Throwable
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function fetchOne(array $searchConditions, array $selectColumns = ['*']): Customer
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->firstOrFail();
    }

    /**
     * DBに保存する前に、対象データを暗号化。
     * @param  array<string, mixed> $params
     * @param  array $targetFields
     * @return array<string, mixed>
     * @throws \Throwable
     */
    public function encryptData(array $params): array
    {
        foreach($params as $key => $value) {
            switch ($key) {
                case 'password':
                    $params[$key] = Hash::make(($params['password']));
                    break;
                case 'email':
                    $params[$key] = $value;
                    break;
                case 'status':
                    $params[$key] = $value;
                    break;
                default :
                    $params[$key] = $this->encrypt($value);
                    break;

            }
        }
        return $params;
    }

    /**
     * 単一のユーザー情報を登録する。
     * @param  array<string, mixed> $params
     * @return Customer
     * @throws \Throwable
     */
    public function store(array $params): Customer
    {
        $customer = new Customer();
        $customer->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $customer->fill($this->encryptData($params))->save();

        return $customer;
    }

    /**
     * 単一のユーザー情報を更新する。
     * @param  array<string, mixed> $params
     * @param  Customer $customer
     * @return void
     * @throws \Throwable
     */
    public function update(Customer $customer, array $params): void
    {
        $customer->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $customer->update($this->encryptData($params));
    }

    /**
     * 単一のユーザー情報を削除する。
     * @param  Customer $customer
     * @return void
     * @throws \Throwable
     */
    public function delete(Customer $customer): void
    {
        $customer->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $customer->delete();
    }

    /**
     * 最終ログイン日時を更新する。
     * ※ ログインにはメールアドレスを使用していて、ユニーク制約もあるのでIDに変換して検索はしていない。
     * @param  string $email
     * @return void
     */
    public function updateLastLoginDate(string $email): void
    {
        $customer = $this->makeBasicBuilder(['email' => $email])->firstOrFail();
        $customer->setAttribute('last_login_at', Carbon::now());

        $customer->timestamps = false; // updated_atは更新しない
        $customer->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE)->save();
        $customer->timestamps = true;
    }

    /**
     * 標準的な設定をしたビルダーを作成する。
     * @param  array $searchConditions
     * @param  array $selectColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function makeBasicBuilder(array $searchConditions, array $selectColumns = ['*']): Builder
    {
        /** @var Customer $builder */
        $builder = Customer::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect($selectColumns);

        return $builder->whereMultiConditions($searchConditions);
    }
}
