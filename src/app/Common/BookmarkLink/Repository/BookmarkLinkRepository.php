<?php
namespace App\Common\BookmarkLink\Repository;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\BookmarkLink\Contract\BookmarkLinkRepository as BookmarkLinkRepositoryContract;
use App\Common\BookmarkLink\Model\BookmarkLink;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\RepositoryConnection;

/**
 * BookmarkLinkモデルのデータ操作を扱うクラス。
 * @package \App\Common\BookmarkLink
 */
class BookmarkLinkRepository implements BookmarkLinkRepositoryContract
{
    use RepositoryConnection;

    /**
     * 検索条件に合致したデータを持つBookmarkLinkモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAll(array $searchConditions, array $selectColumns = ['id', 'name', 'link']): Collection
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->get();
    }

    /**
     * 検索条件に合致したデータを持つBookmarkLinkモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function fetchAsPaginator(array $searchConditions, array $selectColumns = ['*']): LengthAwarePaginator
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->paginate();
    }

    /**
     * 検索条件に合致した単一のBookmarkLinkモデルを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \App\Common\BookmarkLink\Model\BookmarkLink
     * @throws \Throwable
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function fetchOne(array $searchConditions, array $selectColumns = ['*']): BookmarkLink
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->firstOrFail();
    }

    /**
     * 単一の管理ユーザー情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\BookmarkLink\Model\BookmarkLink
     * @throws \Throwable
     */
    public function store(array $params): BookmarkLink
    {
        $bookmarkLink = new BookmarkLink();
        $bookmarkLink->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $bookmarkLink->fill($params)->save();

        return $bookmarkLink;
    }

    /**
     * 単一のBookmarkLink情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\BookmarkLink\Model\BookmarkLink $bookmarkLink
     * @return void
     * @throws \Throwable
     */
    public function update(BookmarkLink $bookmarkLink, array $params): void
    {
        $bookmarkLink->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $bookmarkLink->update($params);
    }

    /**
     * 単一のBookmarkLink情報を削除する。
     * @param  \App\Common\BookmarkLink\Model\BookmarkLink $Sample
     * @return void
     * @throws \Throwable
     */
    public function delete(BookmarkLink $bookmarkLink): void
    {
        $bookmarkLink->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $bookmarkLink->delete();
    }

    /**
     * 標準的な設定をしたビルダーを作成する。
     * @param  array $searchConditions
     * @param  array $selectColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function makeBasicBuilder(array $searchConditions, array $selectColumns = ['*']): Builder
    {
        /** @var \App\Common\BookmarkLink\Model\BookmarkLink $builder */
        $builder = BookmarkLink::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect($selectColumns);

        return $builder->whereMultiConditions($searchConditions);
    }
}
