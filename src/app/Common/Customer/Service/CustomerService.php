<?php

namespace App\Common\Customer\Service;

use App\Common\Customer\Contract\CustomerRepository as CustomerRepositoryContract;
use App\Common\Customer\Model\Customer;
use App\Common\Customer\ViewModel\CustomerViewModel;
use Illuminate\Support\Facades\DB;
use App\Common\Database\MysqlCryptorTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Common\Database\RepositoryConnection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Repository\ViewModelRepositoryTrait;
use Illuminate\Http\ResponseTrait;

/**
 * ユーザー情報に関連する処理を行うクラス。
 * @package \App\Common\Customer
 */
class CustomerService
{
    use RepositoryConnection, ViewModelRepositoryTrait, MysqlCryptorTrait;
    /**
     * Customerモデルのデータ操作を扱うクラス。
     * @var CustomerRepositoryContract
     */
    private CustomerRepositoryContract $customerRepository;

    /**
     * constructor.
     * @param CustomerRepositoryContract $customerRepository
     */
    public function __construct(CustomerRepositoryContract $customerRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->setViewModel(new CustomerViewModel());
    }

    /**
     * 検索条件に合致したデータを持つCustomerモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollection(array $searchConditions): Collection
    {
        return $this->customerRepository->fetchAll($searchConditions)->keyBy('id');
    }

    /**
     * 検索条件に合致した単一のデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return Customer|null Customerオブジェクト or null
     * @throws \Throwable
     */
    public function getModel(array $searchConditions): ?Customer
    {
        return $this->customerRepository->fetchOne($searchConditions);
    }

    /**
     * 検索条件に合致したデータを持つCustomerモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginator(array $searchConditions): LengthAwarePaginator
    {
        $paginator = $this->customerRepository->fetchAsPaginator($searchConditions)->appends($searchConditions);
        $paginator->setCollection($paginator->getCollection());
        return $paginator;
    }

    /**
     * 単一のユーザー情報を登録する。
     * @param  array $params
     * @return Customer
     * @throws \Throwable
     */
    public function storeModel(array $params): Customer
    {
        return DB::transaction(function () use ($params) {
            return $this->customerRepository->store($params);
        });
    }

    /**
     * 単一のユーザー情報を更新する。
     * @param  Customer $customer
     * @param  array<string, mixed> $params
     * @return void
     * @throws \Throwable
     */
    public function updateModel(Customer $customer, array $params): void
    {
        DB::transaction(function () use ($customer, $params) {
            $this->customerRepository->update($customer, $params);
        });
    }

    /**
     * 単一のユーザー情報を削除する。
     * @param  Customer $customer
     * @return void
     * @throws \Throwable
     */
    public function deleteModel(Customer $customer): void
    {
        DB::transaction(function () use ($customer) {
            $this->customerRepository->delete($customer);
        });
    }

    /**
     * 最終ログイン日時を更新する。
     * @param  string $email
     * @return void
     * @throws \Throwable
     */
    public function updateLastLoginDate(string $email): void
    {
        DB::transaction(function () use ($email) {
            $this->customerRepository->updateLastLoginDate($email);
        });
    }

    /**
     * ViewModelオブジェクトのコレクションとしてデータを取得する。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Database\Eloquent\Collection|null ViewModelContractを実装するクラスのコレクション or null
     * @throws \Throwable
     */
    public function getViewModelCollection(array $searchConditions = []): ?Collection
    {
        return $this->makeViewModels($this->getCollection($searchConditions));
    }

    /**
     * 単一のViewModelオブジェクトとしてデータを取得する。
     *
     * @param  array $searchConditions 検索条件の配列
     * @param bool $writeConnection
     * @return CustomerViewModel|null CustomerViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function getViewModel(array $searchConditions): ?CustomerViewModel
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $this->makeViewModel($collection->first()) : null;
    }

    /**
     * 単一のViewModelオブジェクトとしてデータを取得する。
     *
     * @param \App\Customer\Model\Customer
     * @param bool $writeConnection
     * @return \App\Common\Customer\ViewModel\CustomerViewModel|null CustomerViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function convertoToViewModel(array $array): ?CustomerViewModel
    {
        return $this->makeViewModel(Customer::make($array));
    }

    /**
     * ViewModelのデータをPaginatorとして取得する。
     *
     * @param  string $path URLの元になるパス
     * @param  int $page ページ番号
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getViewModelPaginator(string $path, array $searchConditions = [], int $perPage = 30): LengthAwarePaginator
    {
        /** @var \App\Common\Customer\Model\Customer $builder */
        $builder = Customer::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect([
                Customer::TABLE_NAME . '.*',
            ])
            ->orderBy('updated_at', 'desc');

        /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
        $paginator = $builder->whereMultiConditions($searchConditions)->paginate($perPage);
        $collection = $this->makeViewModels($paginator->getCollection());
        $paginator->setCollection($collection);

        return $paginator;
    }
}
