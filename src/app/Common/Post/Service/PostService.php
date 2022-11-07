<?php
namespace App\Common\Post\Service;

use Illuminate\Support\Arr;
use App\Common\Post\Model\Post;
use Illuminate\Support\Facades\DB;
use App\Common\Post\ViewModel\PostViewModel;
use Illuminate\Database\Eloquent\Collection;
use App\Common\Database\RepositoryConnection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Repository\ViewModelRepositoryTrait;
use App\Common\Post\Contract\PostRepository as PostRepositoryContract;

/**
 * Post情報に関連する処理を行うクラス。
 * @package \App\Common\Post
 */
class PostService
{
    use RepositoryConnection, ViewModelRepositoryTrait;

    /**
     * Postモデルのデータ操作を扱うクラス。
     * @var \App\Common\Post\Repository\PostRepository
     */
    private PostRepositoryContract $repository;

    /**
     * constructor.
     * @param PostRepositoryContract $repository
     */
    public function __construct(PostRepositoryContract $repository)
    {
        $this->repository = $repository;
        $this->setViewModel(new PostViewModel());
    }

    /**
     * 検索条件に合致したデータを持つPostモデルのコレクションを取得する。
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
     * @return \App\Common\Post\Model\Post|null Agencyオブジェクト or null
     * @throws \Throwable
     */
    public function getModel(array $searchConditions): ?Post
    {
        return $this->repository->fetchOne($searchConditions);
    }

    /**
     * 検索条件に合致したデータを持つPostモデルをページネーターとして取得する。
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
     * 単一の管理Post情報を登録する。
     * @param  array $params
     * @return \App\Common\Post\Model\Post
     * @throws \Throwable
     */
    public function storeModel(array $params): Post
    {
        return DB::transaction(function () use ($params) {
            return $this->repository->store($params);
        });
    }

    /**
     * 単一の管理Post情報を更新する。
     * @param  \App\Common\Post\Model\Post $post
     * @param  array<string, mixed> $params
     * @return void
     * @throws \Throwable
     */
    public function updateModel(Post $post, array $params): void
    {
        DB::transaction(function () use ($post, $params) {
            $this->repository->update($post, $params);
        });
    }

    /**
     * 単一の管理Post情報を削除する。
     * @param  \App\Common\Post\Model\Post $post
     * @return void
     * @throws \Throwable
     */
    public function deleteModel(Post $post): void
    {
        DB::transaction(function () use ($post) {
            $this->repository->delete($post);
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
     * @return PostViewModel|null PostViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function getViewModel(array $searchConditions, bool $writeConnection = false): ?PostViewModel
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $this->makeViewModel($collection->first()): null;
    }

    /**
     * Convert array to viewModel
     *
     * @param array $param
     * @return PostViewModel|null
     */
    public function convertArrayToViewModel(array $param): ?PostViewModel
    {
        return $this->makeViewModel(Post::make($param));
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
        $builder =  Post::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect([
                Post::TABLE_NAME.'.*',
            ])
            ->orderBy('updated_at', 'desc');
       
        /** @var \App\Common\Post\Model\Post $builder */
        $paginator = $builder->whereMultiConditions($searchConditions)->paginate($perPage);

        return $paginator->setCollection($paginator->getCollection());
    }
}
