<?php
namespace App\Common\AgencyContract\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\AgencyContract\Contract\AgencyContractRepository as AgencyContractRepositoryContract;
use App\Common\AgencyContract\Model\AgencyContract;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\RepositoryConnection;

/**
 * AgencyContractモデルのデータ操作を扱うクラス。
 * @package \App\Common\AgencyContract
 */
class AgencyContractRepository implements AgencyContractRepositoryContract
{
    use RepositoryConnection;

    /**
     * 検索条件に合致したデータを持つAgencyContractモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAll(array $searchConditions, array $selectColumns = ['*']): Collection
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->get();
    }

    /**
     * 検索条件に合致したデータを持つAgencyContractモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function fetchAsPaginator(array $searchConditions, array $selectColumns = ['*']): LengthAwarePaginator
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->paginate();
    }

    /**
     * 検索条件に合致した単一のAgencyContractモデルを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return AgencyContract
     * @throws \Throwable
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function fetchOne(array $searchConditions, array $selectColumns = ['*']): AgencyContract
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->firstOrFail();
    }

    /**
     * 単一のAgencyContract情報を登録する。
     * @param  array<string, mixed> $params
     * @return AgencyContract
     * @throws \Throwable
     */
    public function store(array $params): AgencyContract
    {
        $agency = new AgencyContract();
        $agency->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $agency->fill($params)->save();

        return $agency;
    }

    /**
     * 単一のAgencyContract情報を更新する。
     * @param  array<string, mixed> $params
     * @param  AgencyContract $agencyContract
     * @return void
     * @throws \Throwable
     */
    public function update(AgencyContract $agencyContract, array $params): void
    {
        $agencyContract->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $agencyContract->update($params);
    }

    /**
     * 単一のAgencyContract情報を削除する。
     * @param  AgencyContract $agencyContract
     * @return void
     * @throws \Throwable
     */
    public function delete(AgencyContract $agencyContract): void
    {
        $agencyContract->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $agencyContract->delete();
    }

    /**
     * 標準的な設定をしたビルダーを作成する。
     * @param  array $searchConditions
     * @param  array $selectColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function makeBasicBuilder(array $searchConditions, array $selectColumns = ['*']): Builder
    {
        /** @var AgencyContract $builder */
        $builder = AgencyContract::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect($selectColumns);

        return $builder->whereMultiConditions($searchConditions);
    }
}
