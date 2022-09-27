<?php
namespace App\Common\Sample\Service;

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
}
