<?php

namespace App\Common\News\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\News\Contract\NewsRepository as NewsRepositoryContract;
use App\Common\News\Model\News;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\RepositoryConnection;

/**
 * Newsモデルのデータ操作を扱うクラス。
 * @package \App\Common\News\Repository
 */
class NewsRepository implements NewsRepositoryContract
{
    use RepositoryConnection;

    /**
     * 検索条件に合致したデータを持つNewsモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAll(array $searchConditions, array $selectColumns = ['*']): Collection
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->get();
    }

    /**
     * 検索条件に合致したデータを持つNewsモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function fetchAsPaginator(array $searchConditions, array $selectColumns = ['*']): LengthAwarePaginator
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->paginate();
    }

    /**
     * 検索条件に合致した単一のNewsモデルを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return News
     * @throws \Throwable
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function fetchOne(array $searchConditions, array $selectColumns = ['*']): News
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->firstOrFail();
    }

    /**
     * 単一のNews情報を登録する。
     * @param  array<string, mixed> $params
     * @return News
     * @throws \Throwable
     */
    public function store(array $params): News
    {
        $clientNews = new News();
        $clientNews->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $clientNews->fill($params)->save();

        return $clientNews;
    }

    /**
     * 単一のNews情報を更新する。
     * @param  array<string, mixed> $params
     * @param  News $news
     * @return void
     * @throws \Throwable
     */
    public function update(News $news, array $params): void
    {
        $news->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $news->update($params);
    }

    /**
     * 単一のNews情報を削除する。
     * @param  News $news
     * @return void
     * @throws \Throwable
     */
    public function delete(News $news): void
    {
        $news->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $news->delete();
    }

    /**
     * 標準的な設定をしたビルダーを作成する。
     * @param  array $searchConditions
     * @param  array $selectColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function makeBasicBuilder(array $searchConditions, array $selectColumns = ['*']): Builder
    {
        /**
         * @var News $builder
         */
        $builder = News::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect($selectColumns);

        return $builder->whereMultiConditions($searchConditions);
    }
}
