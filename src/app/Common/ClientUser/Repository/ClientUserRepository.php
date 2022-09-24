<?php
namespace App\Common\ClientUser\Repository;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\ClientUser\Contract\ClientUserRepository as ClientUserRepositoryContract;
use App\Common\ClientUser\Model\ClientUser;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\RepositoryConnection;

/**
 * ClientUserモデルのデータ操作を扱うクラス。
 * @package \App\Common\ClientUser
 */
class ClientUserRepository implements ClientUserRepositoryContract
{
    use RepositoryConnection;

    /**
     * 検索条件に合致したデータを持つClientUserモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAll(array $searchConditions, array $selectColumns = ['*']): Collection
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->get();
    }

    /**
     * 検索条件に合致したデータを持つClientUserモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function fetchAsPaginator(array $searchConditions, array $selectColumns = ['*']): LengthAwarePaginator
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->paginate();
    }

    /**
     * 検索条件に合致した単一のClientUserモデルを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \App\Common\ClientUser\Model\ClientUser
     * @throws \Throwable
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function fetchOne(array $searchConditions, array $selectColumns = ['*']): ClientUser
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->firstOrFail();
    }

    /**
     * 単一の企業ユーザー情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\ClientUser\Model\ClientUser
     * @throws \Throwable
     */
    public function store(array $params): ClientUser
    {
        $clientUser = new ClientUser();
        $clientUser->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $clientUser->fill($params)->save();

        return $clientUser;
    }

    /**
     * 単一の企業ユーザー情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\ClientUser\Model\ClientUser $clientUser
     * @return void
     * @throws \Throwable
     */
    public function update(ClientUser $clientUser, array $params): void
    {
        $clientUser->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $clientUser->update($params);
    }

    /**
     * 単一の企業ユーザー情報を削除する。
     * @param  \App\Common\ClientUser\Model\ClientUser $clientUser
     * @return void
     * @throws \Throwable
     */
    public function delete(ClientUser $clientUser): void
    {
        $clientUser->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $clientUser->delete();
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
        /** @var \App\Common\ClientUser\Model\ClientUser $builder */
        $builder = ClientUser::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect($selectColumns);

        return $builder->whereMultiConditions($searchConditions);
    }
}
