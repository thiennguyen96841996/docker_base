<?php
namespace App\Common\Sample\Service;

use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Repository\ViewModelRepositoryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Common\Sample\Contract\SampleRepository as SampleRepositoryContract;
use App\Common\Sample\Model\Sample;

/**
 * 企業ユーザー情報に関連する処理を行うクラス。
 * @package \App\Common\Sample
 */
class SampleService
{
    use ViewModelRepositoryTrait;
    /**
     * Sampleモデルのデータ操作を扱うクラス。
     * @var \App\Common\Sample\Repository\SampleRepository
     */
    private SampleRepositoryContract $repository;

    /**
     * constructor.
     * @param SampleRepositoryContract $repository
     */
    public function __construct(SampleRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 検索条件に合致したデータを持つSampleモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollection(array $searchConditions): Collection
    {
        return $this->repository->fetchAll($searchConditions)->keyBy('id');
    }

    /**
     * 検索条件に合致したデータを持つSampleモデルをページネーターとして取得する。
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
     * 単一の管理ユーザー情報を登録する。
     * @param  array $params
     * @return \App\Common\Sample\Model\Sample
     * @throws \Throwable
     */
    public function storeModel(array $params): Sample
    {
        return DB::transaction(function () use ($params) {
            return $this->repository->store($params);
        });
    }

    /**
     * 単一の管理ユーザー情報を更新する。
     * @param  \App\Common\Sample\Model\Sample $sample
     * @param  array<string, mixed> $params
     * @return void
     * @throws \Throwable
     */
    public function updateModel(Sample $sample, array $params): void
    {
        DB::transaction(function () use ($sample, $params) {
            $this->repository->update($sample, $params);
        });
    }

    /**
     * 単一の管理ユーザー情報を削除する。
     * @param  \App\Common\Sample\Model\Sample $sample
     * @return void
     * @throws \Throwable
     */
    public function deleteModel(Sample $sample): void
    {
        DB::transaction(function () use ($sample) {
            $this->repository->delete($sample);
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
     * @return \App\Common\Sample\ViewModel\SampleViewModel|null SampleViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function getViewModel(array $searchConditions, bool $writeConnection = false): ?\App\Common\ViewModel\SampleViewModel
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
        $builder =  Sample::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect([
                Sample::TABLE_NAME.'.*',
            ])
            ->orderBy('updated_at', 'desc')
        ;

        /** @var \App\Common\Sample\Model\Sample $builder */
        $paginator = $builder->whereMultiConditions($searchConditions)->paginate($page);

        return $paginator->setCollection($paginator->getCollection());
    }
}
