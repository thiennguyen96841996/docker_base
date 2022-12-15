<?php

namespace App\Common\Project\Service;

use Illuminate\Support\Arr;
use App\Common\Project\Model\Project;
use Illuminate\Support\Facades\DB;
use App\Common\Project\ViewModel\ProjectViewModel;
use Illuminate\Database\Eloquent\Collection;
use App\Common\Database\RepositoryConnection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Repository\ViewModelRepositoryTrait;
use App\Common\Project\Contract\ProjectRepository as ProjectRepositoryContract;

/**
 * Project情報に関連する処理を行うクラス。
 * @package \App\Common\Project
 */
class ProjectService
{
    use RepositoryConnection, ViewModelRepositoryTrait;

    /**
     * Projectモデルのデータ操作を扱うクラス。
     * @var \App\Common\Project\Repository\ProjectRepository
     */
    private ProjectRepositoryContract $repository;

    /**
     * constructor.
     * @param ProjectRepositoryContract $repository
     */
    public function __construct(ProjectRepositoryContract $repository)
    {
        $this->repository = $repository;
        $this->setViewModel(new ProjectViewModel());
    }

    /**
     * 検索条件に合致したデータを持つProjectモデルのコレクションを取得する。
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
     * @return \App\Common\Project\Model\Project|null Agencyオブジェクト or null
     * @throws \Throwable
     */
    public function getModel(array $searchConditions): ?Project
    {
        return $this->repository->fetchOne($searchConditions);
    }

    /**
     * 検索条件に合致したデータを持つProjectモデルをページネーターとして取得する。
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
     * 単一の管理Project情報を登録する。
     * @param  array $params
     * @return \App\Common\Project\Model\Project
     * @throws \Throwable
     */
    public function storeModel(array $params): Project
    {
        return DB::transaction(function () use ($params) {
            return $this->repository->store($params);
        });
    }

    /**
     * 単一の管理Project情報を更新する。
     * @param  \App\Common\Project\Model\Project $project
     * @param  array<string, mixed> $params
     * @return void
     * @throws \Throwable
     */
    public function updateModel(Project $project, array $params): void
    {
        DB::transaction(function () use ($project, $params) {
            $this->repository->update($project, $params);
        });
    }

    /**
     * 単一の管理Project情報を削除する。
     * @param  \App\Common\Project\Model\Project $project
     * @return void
     * @throws \Throwable
     */
    public function deleteModel(Project $project): void
    {
        DB::transaction(function () use ($project) {
            $this->repository->delete($project);
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
     * @param bool $writeConnection
     * @return ProjectViewModel|null ProjectViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function getViewModel(array $searchConditions, bool $writeConnection = false): ?ProjectViewModel
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $this->makeViewModel($collection->first()) : null;
    }

    /**
     * Convert array to viewModel
     *
     * @param array $param
     * @return ProjectViewModel|null
     */
    public function convertArrayToViewModel(array $param): ?ProjectViewModel
    {
        return $this->makeViewModel(Project::make($param));
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
        $builder =  Project::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect([
                Project::TABLE_NAME . '.*',
            ])
            ->orderBy('updated_at', 'desc');

        /** @var \App\Common\Project\Model\Project $builder */
        $paginator = $builder->whereMultiConditions($searchConditions)->paginate($perPage);

        return $paginator->setCollection($paginator->getCollection());
    }
}
