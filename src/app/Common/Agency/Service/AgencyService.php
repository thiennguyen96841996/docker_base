<?php
namespace App\Common\Agency\Service;

use App\Common\Agency\ViewModel\AgencyViewModel;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Repository\ViewModelRepositoryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Common\Agency\Contract\AgencyRepository as AgencyRepositoryContract;
use App\Common\Agency\Model\Agency;
use App\Common\Database\RepositoryConnection;

/**
 * Agency情報に関連する処理を行うクラス。
 * @package \App\Common\Agency
 */
class AgencyService
{
    use RepositoryConnection, ViewModelRepositoryTrait;

    /**
     * Agencyモデルのデータ操作を扱うクラス。
     * @var \App\Common\Agency\Repository\AgencyRepository
     */
    private AgencyRepositoryContract $repository;

    /**
     * constructor.
     * @param AgencyRepositoryContract $repository
     */
    public function __construct(AgencyRepositoryContract $repository)
    {
        $this->repository = $repository;
        $this->setViewModel(new AgencyViewModel());
    }

    /**
     * 検索条件に合致したデータを持つAgencyモデルのコレクションを取得する。
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
     * @return \App\Common\Agency\Model\Agency|null Agencyオブジェクト or null
     * @throws \Throwable
     */
    public function getModel(array $searchConditions): ?Agency
    {
        return $this->repository->fetchOne($searchConditions);
    }

    /**
     * 検索条件に合致したデータを持つAgencyモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginator(array $searchConditions): LengthAwarePaginator
    {
        $paginator = $this->repository->fetchAsPaginator($searchConditions)->appends($searchConditions);
        $paginator->setCollection($paginator->getCollection()->keyBy('id'));
        return $paginator;
    }

    /**
     * 単一のAgency情報を登録する。
     * @param  array $params
     * @return \App\Common\Agency\Model\Agency
     * @throws \Throwable
     */
    public function storeModel(array $params): Agency
    {
        return DB::transaction(function () use ($params) {
            return $this->repository->store($params);
        });
    }

    /**
     * 単一のAgency情報を更新する。
     * @param  \App\Common\Agency\Model\Agency $agency
     * @param  array<string, mixed> $params
     * @return void
     * @throws \Throwable
     */
    public function updateModel(Agency $agency, array $params): void
    {
        DB::transaction(function () use ($agency, $params) {
            $this->repository->update($agency, $params);
        });
    }

    /**
     * 単一のAgency情報を削除する。
     * @param  \App\Common\Agency\Model\Agency $agency
     * @return void
     * @throws \Throwable
     */
    public function deleteModel(Agency $agency): void
    {
        DB::transaction(function () use ($agency) {
            $this->repository->delete($agency);
        });
    }

    /**
     * ViewModelオブジェクトのコレクションとしてデータを取得する。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Support\Collection|null ViewModelContractを実装するクラスのコレクション or null
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
     * @return AgencyViewModel|null AdminUserViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function getViewModel(array $searchConditions): ?AgencyViewModel
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $this->makeViewModel($collection->first()): null;
    }

    /**
     * ViewModelのデータをPaginatorとして取得する。
     *
     * @param  string $path URLの元になるパス
     * @param  int $page ページ番号
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getViewModelPaginator(string $path, int $page, array $searchConditions = []): LengthAwarePaginator
    {
        $builder =  Agency::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect([
                Agency::TABLE_NAME.'.*',
            ])
            ->orderBy('updated_at', 'desc')
        ;

        /** @var \App\Common\Agency\Model\Agency $builder */
        $paginator = $builder->whereMultiConditions($searchConditions)->paginate($page);

        return $paginator->setCollection($paginator->getCollection());
    }
}
