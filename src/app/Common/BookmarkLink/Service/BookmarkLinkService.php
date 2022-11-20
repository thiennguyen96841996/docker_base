<?php
namespace App\Common\BookmarkLink\Service;

use App\Common\BookmarkLink\ViewModel\BookmarkLinkViewModel;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Repository\ViewModelRepositoryTrait;
use App\Common\View\Contract\ViewModel as ViewModelContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Common\BookmarkLink\Contract\BookmarkLinkRepository as BookmarkLinkRepositoryContract;
use App\Common\BookmarkLink\Model\BookmarkLink;
use App\Common\Database\RepositoryConnection;

/**
 * BookmarkLink情報に関連する処理を行うクラス。
 * @package \App\Common\BookmarkLink
 */
class BookmarkLinkService
{
    use RepositoryConnection, ViewModelRepositoryTrait;

    /**
     * BookmarkLinkモデルのデータ操作を扱うクラス。
     * @var \App\Common\BookmarkLink\Repository\BookmarkLinkRepository
     */
    private BookmarkLinkRepositoryContract $repository;

    /**
     * constructor.
     * @param BookmarkLinkRepositoryContract $repository
     */
    public function __construct(BookmarkLinkRepositoryContract $repository)
    {
        $this->repository = $repository;
        $this->setViewModel(new BookmarkLinkViewModel());
    }

    /**
     * 検索条件に合致したデータを持つBookmarkLinkモデルのコレクションを取得する。
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
     * @return \App\Common\BookmarkLink\Model\BookmarkLink|null BookmarkLinkオブジェクト or null
     * @throws \Throwable
     */
    public function getModel(array $searchConditions): ?BookmarkLink
    {
        return $this->repository->fetchOne($searchConditions);
    }

    /**
     * 検索条件に合致したデータを持つBookmarkLinkモデルをページネーターとして取得する。
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
     * 単一のBookmarkLink情報を登録する。
     * @param  array $params
     * @return \App\Common\BookmarkLink\Model\BookmarkLink
     * @throws \Throwable
     */
    public function storeModel(array $params): BookmarkLink
    {
        return DB::transaction(function () use ($params) {
            return $this->repository->store($params);
        });
    }

    /**
     * 単一のBookmarkLink情報を更新する。
     * @param  \App\Common\BookmarkLink\Model\BookmarkLink $bookmarkLink
     * @param  array<string, mixed> $params
     * @return void
     * @throws \Throwable
     */
    public function updateModel(BookmarkLink $bookmarkLink, array $params): void
    {
        DB::transaction(function () use ($bookmarkLink, $params) {
            $this->repository->update($bookmarkLink, $params);
        });
    }

    /**
     * 単一のBookmarkLink情報を削除する。
     * @param  \App\Common\BookmarkLink\Model\BookmarkLink $bookmarkLink
     * @return void
     * @throws \Throwable
     */
    public function deleteModel(BookmarkLink $bookmarkLink): void
    {
        DB::transaction(function () use ($bookmarkLink) {
            $this->repository->delete($bookmarkLink);
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
     * @return BookmarkLinkViewModel|null AdminUserViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function getViewModel(array $searchConditions): ?BookmarkLinkViewModel
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $this->makeViewModel($collection->first()): null;
    }

    /**
     * Convert array to viewModel
     *
     * @param array $param
     * @return BookmarkLinkViewModel|null
     */
    public function convertArrayToViewModel(array $param): ?BookmarkLinkViewModel
    {
        return $this->makeViewModel(BookmarkLink::make($param));
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
        $builder =  BookmarkLink::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect([
                BookmarkLink::TABLE_NAME.'.*',
            ])
            ->orderBy('id', 'desc')
        ;

        /** @var \App\Common\BookmarkLink\Model\BookmarkLink $builder */
        $paginator = $builder->whereMultiConditions($searchConditions)->paginate($perPage);

        return $paginator->setCollection($paginator->getCollection());
    }
}
