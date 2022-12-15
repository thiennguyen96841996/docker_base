<?php

namespace App\Common\Project\Repository;

use App\Common\CityMaster\Model\CityMaster;
use App\Common\ClientUser\Model\ClientUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\Project\Contract\ProjectRepository as ProjectRepositoryContract;
use App\Common\Project\Model\Project;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\RepositoryConnection;
use App\Common\DistrictMaster\Model\DistrictMaster;
use App\Common\ProjectCategoryMaster\Model\ProjectCategoryMaster;
use App\Common\RegionMaster\Model\RegionMaster;

/**
 * Projectモデルのデータ操作を扱うクラス。
 * @package \App\Common\Project
 */
class ProjectRepository implements ProjectRepositoryContract
{
    use RepositoryConnection;

    /**
     * 検索条件に合致したデータを持つProjectモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAll(array $searchConditions, array $selectColumns = ['*']): Collection
    {
        $selectColumns = [
            Project::TABLE_NAME . '.*',
            ClientUser::TABLE_NAME . '.name AS client_name',
            CityMaster::TABLE_NAME . '.city_name',
            DistrictMaster::TABLE_NAME . '.district_name',
            RegionMaster::TABLE_NAME . '.region_name',
            ProjectCategoryMaster::TABLE_NAME . '.project_category_name',
        ];
        return $this->makeBasicBuilder($searchConditions, $selectColumns)
            ->leftJoin(ClientUser::TABLE_NAME, Project::TABLE_NAME . '.client_id', '=', ClientUser::TABLE_NAME . '.id')
            ->leftJoin(ProjectCategoryMaster::TABLE_NAME, Project::TABLE_NAME . '.project_category_code', '=', ProjectCategoryMaster::TABLE_NAME . '.project_category_code')
            ->leftJoin(CityMaster::TABLE_NAME, Project::TABLE_NAME . '.city_code', '=', CityMaster::TABLE_NAME . '.city_code')
            ->leftJoin(DistrictMaster::TABLE_NAME, Project::TABLE_NAME . '.district_code', '=', DistrictMaster::TABLE_NAME . '.district_code')
            ->leftJoin(RegionMaster::TABLE_NAME, Project::TABLE_NAME . '.region_code', '=', RegionMaster::TABLE_NAME . '.region_code')
            ->get();
    }

    /**
     * 検索条件に合致したデータを持つProjectモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function fetchAsPaginator(array $searchConditions, array $selectColumns = ['*']): LengthAwarePaginator
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->paginate();
    }

    /**
     * 検索条件に合致した単一のProjectモデルを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \App\Common\Project\Model\Project
     * @throws \Throwable
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function fetchOne(array $searchConditions, array $selectColumns = ['*']): Project
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->firstOrFail();
    }

    /**
     * 単一の管理Project情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\Project\Model\Project
     * @throws \Throwable
     */
    public function store(array $params): Project
    {
        $project = new Project();
        $project->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $project->fill($params)->save();

        return $project;
    }

    /**
     * 単一の管理Project情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\Project\Model\Project $project
     * @return void
     * @throws \Throwable
     */
    public function update(Project $project, array $params): void
    {
        $project->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $project->update($params);
    }

    /**
     * 単一の管理Project情報を削除する。
     * @param  \App\Common\Project\Model\Project $project
     * @return void
     * @throws \Throwable
     */
    public function delete(Project $project): void
    {
        $project->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $project->delete();
    }

    /**
     * 標準的な設定をしたビルダーを作成する。
     * @param  array $searchConditions
     * @param  array $selectColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function makeBasicBuilder(array $searchConditions, array $selectColumns = ['*']): Builder
    {
        /** @var \App\Common\Project\Model\Project $builder */
        $builder = Project::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect($selectColumns);

        return $builder->whereMultiConditions($searchConditions);
    }
}
