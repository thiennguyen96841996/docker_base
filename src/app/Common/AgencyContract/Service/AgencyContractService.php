<?php
namespace App\Common\AgencyContract\Service;

use App\Common\AgencyContract\ViewModel\AgencyContractViewModel;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Repository\ViewModelRepositoryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Common\AgencyContract\Contract\AgencyContractRepository as AgencyContractRepositoryContract;
use App\Common\AgencyContract\Model\AgencyContract;
use App\Common\Database\RepositoryConnection;

/**
 * AgencyContract情報に関連する処理を行うクラス。
 * @package \App\Common\AgencyContract
 */
class AgencyContractService
{
    use RepositoryConnection, ViewModelRepositoryTrait;

    /**
     * AgencyContractモデルのデータ操作を扱うクラス。
     * @var AgencyContractRepositoryContract
     */
    private AgencyContractRepositoryContract $repository;

    /**
     * constructor.
     * @param AgencyContractRepositoryContract $repository
     */
    public function __construct(AgencyContractRepositoryContract $repository)
    {
        $this->repository = $repository;
        $this->setViewModel(new AgencyContractViewModel());
    }

    /**
     * 検索条件に合致したデータを持つAgencyContractモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @return Collection
     */
    public function getCollection(array $searchConditions): Collection
    {
        return $this->repository->fetchAll($searchConditions)->keyBy('id');
    }

    /**
     * 検索条件に合致した単一のデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return AgencyContract|null Agencyオブジェクト or null
     * @throws \Throwable
     */
    public function getModel(array $searchConditions): ?AgencyContract
    {
        return $this->repository->fetchOne($searchConditions);
    }

    /**
     * 検索条件に合致したデータを持つAgencyContractモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @return LengthAwarePaginator
     */
    public function getPaginator(array $searchConditions): LengthAwarePaginator
    {
        $paginator = $this->repository->fetchAsPaginator($searchConditions)->appends($searchConditions);
        $paginator->setCollection($paginator->getCollection()->keyBy('id'));
        return $paginator;
    }

    /**
     * 単一のAgencyContract情報を登録する。
     * @param  array $params
     * @return AgencyContract
     * @throws \Throwable
     */
    public function storeModel(array $params): AgencyContract
    {
        return DB::transaction(function () use ($params) {
            return $this->repository->store($params);
        });
    }

    /**
     * 単一のAgencyContract情報を更新する。
     * @param  AgencyContract $agencyContract
     * @param  array<string, mixed> $params
     * @return void
     * @throws \Throwable
     */
    public function updateModel(AgencyContract $agencyContract, array $params): void
    {
        DB::transaction(function () use ($agencyContract, $params) {
            $this->repository->update($agencyContract, $params);
        });
    }

    /**
     * 単一のAgencyContract情報を削除する。
     * @param  AgencyContract $agencyContract
     * @return void
     * @throws \Throwable
     */
    public function deleteModel(AgencyContract $agencyContract): void
    {
        DB::transaction(function () use ($agencyContract) {
            $this->repository->delete($agencyContract);
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
     * @return AgencyContractViewModel|null AgencyContractViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function getViewModel(array $searchConditions): ?AgencyContractViewModel
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $this->makeViewModel($collection->first()): null;
    }

    /**
     * Convert array to viewModel
     *
     * @param array $param
     * @return AgencyContractViewModel|null
     */
    public function convertArrayToViewModel(array $param): ?AgencyContractViewModel
    {
        return $this->makeViewModel(AgencyContract::make($param));
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
        $builder =  AgencyContract::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect([
                AgencyContract::TABLE_NAME.'.*',
            ])
            ->orderBy('updated_at', 'desc')
        ;

        /** @var AgencyContract $builder */
        $paginator = $builder->whereMultiConditions($searchConditions)->paginate($perPage);

        return $paginator->setCollection($paginator->getCollection());
    }
}
