<?php
namespace App\Common\Agency\Repository;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\Agency\Contract\AgencyRepository as AgencyRepositoryContract;
use App\Common\Agency\Model\Agency;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\RepositoryConnection;

/**
 * Agencyモデルのデータ操作を扱うクラス。
 * @package \App\Common\Agency
 */
class AgencyRepository implements AgencyRepositoryContract
{
    use RepositoryConnection;

    /**
     * 検索条件に合致したデータを持つSampleモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAll(array $searchConditions, array $selectColumns = ['*']): Collection
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->get();
    }

    /**
     * 検索条件に合致したデータを持つSampleモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function fetchAsPaginator(array $searchConditions, array $selectColumns = ['*']): LengthAwarePaginator
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->paginate();
    }

    /**
     * 検索条件に合致した単一のAgencyモデルを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \App\Common\Agency\Model\Agency
     * @throws \Throwable
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function fetchOne(array $searchConditions, array $selectColumns = ['*']): Agency
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->firstOrFail();
    }

    /**
     * 単一の管理ユーザー情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\Agency\Model\Agency
     * @throws \Throwable
     */
    public function store(array $params): Agency
    {
        $agency = new Agency();
        $agency->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $agency->fill($params)->save();

        return $agency;
    }

    /**
     * 単一の管理ユーザー情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\Agency\Model\Agency $agency
     * @return void
     * @throws \Throwable
     */
    public function update(Agency $agency, array $params): void
    {
        $agency->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $agency->update($params);
    }

    /**
     * 単一の管理ユーザー情報を削除する。
     * @param  \App\Common\Agency\Model\Agency $Sample
     * @return void
     * @throws \Throwable
     */
    public function delete(Agency $agency): void
    {
        $agency->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $agency->delete();
    }

    /**
     * 標準的な設定をしたビルダーを作成する。
     * @param  array $searchConditions
     * @param  array $selectColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function makeBasicBuilder(array $searchConditions, array $selectColumns = ['*']): Builder
    {
        /** @var \App\Common\Agency\Model\Agency $builder */
        $builder = Agency::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect($selectColumns);

        return $builder->whereMultiConditions($searchConditions);
    }
}
