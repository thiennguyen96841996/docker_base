<?php
namespace App\Common\Post\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\Post\Contract\PostRepository as PostRepositoryContract;
use App\Common\Post\Model\Post;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\RepositoryConnection;

/**
 * Agencyモデルのデータ操作を扱うクラス。
 * @package \App\Common\Agency
 */
class PostRepository implements PostRepositoryContract
{
    use RepositoryConnection;

    /**
     * 検索条件に合致したデータを持つPostモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAll(array $searchConditions, array $selectColumns = ['*']): Collection
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->get();
    }

    /**
     * 検索条件に合致したデータを持つPostモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function fetchAsPaginator(array $searchConditions, array $selectColumns = ['*']): LengthAwarePaginator
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->paginate();
    }

    /**
     * 検索条件に合致した単一のPostモデルを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \App\Common\Post\Model\Post
     * @throws \Throwable
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function fetchOne(array $searchConditions, array $selectColumns = ['*']): Post
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->firstOrFail();
    }

    /**
     * 単一の管理Post情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\Post\Model\Post
     * @throws \Throwable
     */
    public function store(array $params): Post
    {
        $post = new Post();
        $post->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $post->fill($params)->save();

        return $post;
    }

    /**
     * 単一の管理Post情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\Post\Model\Post $post
     * @return void
     * @throws \Throwable
     */
    public function update(Post $post, array $params): void
    {
        $post->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $post->update($params);
    }

    /**
     * 単一の管理Post情報を削除する。
     * @param  \App\Common\Post\Model\Post $post
     * @return void
     * @throws \Throwable
     */
    public function delete(Post $post): void
    {
        $post->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $post->delete();
    }

    /**
     * 標準的な設定をしたビルダーを作成する。
     * @param  array $searchConditions
     * @param  array $selectColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function makeBasicBuilder(array $searchConditions, array $selectColumns = ['*']): Builder
    {
        /** @var \App\Common\Post\Model\Post $builder */
        $builder = Post::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect($selectColumns);

        return $builder->whereMultiConditions($searchConditions);
    }
}
