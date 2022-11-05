<?php
namespace App\Common\ClientUser\Service;

use Illuminate\Support\Facades\DB;
use App\Common\Database\MysqlCryptorTrait;
use App\Common\ClientUser\Model\ClientUser;
use Illuminate\Database\Eloquent\Collection;
use App\Common\Database\RepositoryConnection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Repository\ViewModelRepositoryTrait;
use App\Common\ClientUser\ViewModel\ClientUserViewModel;
use App\Common\ClientUser\Contract\ClientUserRepository as ClientUserRepositoryContract;

/**
 * 企業ユーザー情報に関連する処理を行うクラス。
 * @package \App\Common\ClientUser
 */
class ClientUserService
{
    use RepositoryConnection, ViewModelRepositoryTrait, MysqlCryptorTrait;
    /**
     * ClientUserモデルのデータ操作を扱うクラス。
     * @var \App\Common\ClientUser\Repository\ClientUserRepository
     */
    private ClientUserRepositoryContract $repository;

    /**
     * constructor.
     * @param ClientUserRepositoryContract $repository
     */
    public function __construct(ClientUserRepositoryContract $repository)
    {
        $this->repository = $repository;
        $this->setViewModel(new ClientUserViewModel());
    }

    /**
     * 検索条件に合致したデータを持つClientUserモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollection(array $searchConditions): Collection
    {
        return $this->repository->fetchAll($searchConditions)->keyBy('id');
    }

    /**
     * 検索条件に合致した単一のデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \App\Common\ClientUser\Model\ClientUser|null ClientUserオブジェクト or null
     * @throws \Throwable
     */
    public function getModel(array $searchConditions): ?ClientUser
    {
         return $this->repository->fetchOne($searchConditions);
    }

    /**
     * 検索条件に合致したデータを持つClientUserモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginator(array $searchConditions): LengthAwarePaginator
    {
        $paginator = $this->repository->fetchAsPaginator($searchConditions)->appends($searchConditions);
        $paginator->setCollection($paginator->getCollection());
        return $paginator;
    }

    /**
     * 単一の企業ユーザー情報を登録する。
     * @param  array $params
     * @return \App\Common\ClientUser\Model\ClientUser
     * @throws \Throwable
     */
    public function storeModel(array $params): ClientUser
    {
        return DB::transaction(function () use ($params) {
            return $this->repository->store($params);
        });
    }

    /**
     * 単一の企業ユーザー情報を更新する。
     * @param  \App\Common\ClientUser\Model\ClientUser $clientUser
     * @param  array<string, mixed> $params
     * @return void
     * @throws \Throwable
     */
    public function updateModel(ClientUser $clientUser, array $params): void
    {
        DB::transaction(function () use ($clientUser, $params) {
            $this->repository->update($clientUser, $params);
        });
    }

    /**
     * 単一の企業ユーザー情報を削除する。
     * @param  \App\Common\ClientUser\Model\ClientUser $clientUser
     * @return void
     * @throws \Throwable
     */
    public function deleteModel(ClientUser $clientUser): void
    {
        DB::transaction(function () use ($clientUser) {
            $this->repository->delete($clientUser);
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
            $this->repository->updateLastLoginDate($email);
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
     * @return \App\Common\ClientUser\ViewModel\ClientUserViewModel|null ClientUserViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function getViewModel(array $searchConditions): ?ClientUserViewModel
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $this->makeViewModel($collection->first()): null;
    }

    /**
     * 単一のViewModelオブジェクトとしてデータを取得する。
     *
     * @param \App\Common\ClientUser\Model\ClientUser $clientUser
     * @param bool $writeConnection
     * @return \App\Common\ClientUser\ViewModel\ClientUserViewModel|null ClientUserViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function convertoToViewModel(array $array): ?ClientUserViewModel
    {
        return $this->makeViewModel(ClientUser::make($array));
    }

    /**
     * ViewModelのデータをPaginatorとして取得する。
     *
     * @param  string $path URLの元になるパス
     * @param  int $perPage number of records in each page.
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getViewModelPaginator(string $path, array $searchConditions = [], int $perPage = 30): LengthAwarePaginator
    {
        /** @var \App\Common\ClientUser\Model\ClientUser $builder */
        $builder = ClientUser::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect([
                ClientUser::TABLE_NAME.'.*',
            ])
            ->orderBy('updated_at', 'desc');

        /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
        $paginator = $builder->whereMultiConditions($searchConditions)->paginate($perPage);
        $collection = $this->makeViewModels($paginator->getCollection());
        $paginator->setCollection($collection);

        return $paginator;
    }
}
