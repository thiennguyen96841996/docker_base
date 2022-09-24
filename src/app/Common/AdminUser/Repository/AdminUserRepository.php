<?php
namespace App\Common\AdminUser\Repository;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\AdminUser\Contract\AdminUserRepository as AdminUserRepositoryContract;
use App\Common\AdminUser\Model\AdminUser;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\RepositoryConnection;

/**
 * AdminUserモデルのデータ操作を扱うクラス。
 * @package \App\Common\AdminUser
 */
class AdminUserRepository implements AdminUserRepositoryContract
{
    use RepositoryConnection;

    /**
     * 検索条件に合致したデータを持つAdminUserモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAll(array $searchConditions, array $selectColumns = ['*']): Collection
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->get();
    }

    /**
     * 検索条件に合致したデータを持つAdminUserモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function fetchAsPaginator(array $searchConditions, array $selectColumns = ['*']): LengthAwarePaginator
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->paginate();
    }

    /**
     * 検索条件に合致した単一のAdminUserモデルを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \App\Common\AdminUser\Model\AdminUser
     * @throws \Throwable
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function fetchOne(array $searchConditions, array $selectColumns = ['*']): AdminUser
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->firstOrFail();
    }

    /**
     * 単一の管理ユーザー情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\AdminUser\Model\AdminUser
     * @throws \Throwable
     */
    public function store(array $params): AdminUser
    {
        $adminUser = new AdminUser();
        $adminUser->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $adminUser->fill($params)->save();

        return $adminUser;
    }

    /**
     * 単一の管理ユーザー情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\AdminUser\Model\AdminUser $adminUser
     * @return void
     * @throws \Throwable
     */
    public function update(AdminUser $adminUser, array $params): void
    {
        $adminUser->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $adminUser->update($params);
    }

    /**
     * 単一の管理ユーザー情報を削除する。
     * @param  \App\Common\AdminUser\Model\AdminUser $adminUser
     * @return void
     * @throws \Throwable
     */
    public function delete(AdminUser $adminUser): void
    {
        $adminUser->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $adminUser->delete();
    }

    /**
     * 最終ログイン日時を更新する。
     * ※ ログインにはメールアドレスを使用していて、ユニーク制約もあるのでIDに変換して検索はしていない。
     * @param  string $email
     * @return void
     */
    public function updateLastLoginDate(string $email): void
    {
        $clientUser = $this->makeBasicBuilder([ 'email' => $email ])->firstOrFail();
        $clientUser->setAttribute('last_login_at', Carbon::now());

        $clientUser->timestamps = false; // updated_atは更新しない
        $clientUser->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE)->save();
        $clientUser->timestamps = true;
    }

    /**
     * 標準的な設定をしたビルダーを作成する。
     * @param  array $searchConditions
     * @param  array $selectColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function makeBasicBuilder(array $searchConditions, array $selectColumns = ['*']): Builder
    {
        /** @var \App\Common\AdminUser\Model\AdminUser $builder */
        $builder = AdminUser::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect($selectColumns);

        return $builder->whereMultiConditions($searchConditions);
    }
}
