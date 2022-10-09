<?php

namespace App\Common\News\Service;

use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Repository\ViewModelRepositoryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Common\News\Contract\NewsRepository as NewsRepositoryContract;
use App\Common\News\Model\News;
use App\Common\News\ViewModel\NewsViewModel;
use App\Common\Database\RepositoryConnection;

/**
 * News情報に関連する処理を行うクラス。
 * @package \App\Client\ClientNews\
 */
class NewsService
{
    use RepositoryConnection, ViewModelRepositoryTrait;

    /**
     * Newsモデルのデータ操作を扱うクラス。
     * @var NewsRepositoryContract
     */
    private NewsRepositoryContract $repository;

    /**
     * constructor.
     * @param NewsRepositoryContract $repository
     */
    public function __construct(NewsRepositoryContract $repository)
    {
        $this->repository = $repository;
        $this->setViewModel(new NewsViewModel());
    }

    /**
     * 検索条件に合致したデータを持つNewsモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollection(array $searchConditions): Collection
    {
        return $this->repository->fetchAll($searchConditions)->keyBy('id');
    }

    /**
     * 検索条件に合致したNewsのデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return News|null Newsオブジェクト or null
     * @throws \Throwable
     */
    public function getModel(array $searchConditions): ?News
    {
        return $this->repository->fetchOne($searchConditions);
    }

    /**
     * 検索条件に合致したデータを持つNewsモデルをページネーターとして取得する。
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
     * 単一のNews情報を登録する。
     * @param  array $params
     * @return News
     * @throws \Throwable
     */
    public function storeModel(array $params): News
    {
        return DB::transaction(function () use ($params) {
            return $this->repository->store($params);
        });
    }

    /**
     * 単一のNews情報を更新する。
     * @param  News $news
     * @param  array<string, mixed> $params
     * @return void
     * @throws \Throwable
     */
    public function updateModel(News $news, array $params): void
    {
        DB::transaction(function () use ($news, $params) {
            $this->repository->update($news, $params);
        });
    }

    /**
     * News情報を削除する。
     * @param  News $news
     * @return void
     * @throws \Throwable
     */
    public function deleteModel(News $news): void
    {
        DB::transaction(function () use ($news) {
            $this->repository->delete($news);
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
     * @return NewsViewModel|null ClientNewsViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function getViewModel(array $searchConditions, bool $writeConnection = false): ?NewsViewModel
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $this->makeViewModel($collection->first()) : null;
    }

    /**
     * Convert array to viewModel
     *
     * @param array $param
     * @return NewsViewModel|null
     */
    public function convertArrayToViewModel(array $param): ?NewsViewModel
    {
        return $this->makeViewModel(News::make($param));
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
        $builder =  News::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect([
                News::TABLE_NAME . '.*',
            ])
            ->orderBy('updated_at', 'desc');

        /** @var News $builder */
        $paginator = $builder->whereMultiConditions($searchConditions)->paginate($page);

        return $paginator->setCollection($paginator->getCollection());
    }
}
