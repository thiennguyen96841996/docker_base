<?php
namespace App\Common\ClientUser\Service;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Common\ClientUser\Contract\ClientUserRepository as ClientUserRepositoryContract;
use App\Common\ClientUser\Model\ClientUser;

/**
 * 企業ユーザー情報に関連する処理を行うクラス。
 * @package \App\Common\ClientUser
 */
class ClientUserService
{
    /**
     * ClientUserモデルのデータ操作を扱うクラス。
     * @var \App\Common\ClientUser\Repository\ClientUserRepository
     */
    private ClientUserRepositoryContract $repository;

    /**
     * constructor.
     * @param ClientUserRepositoryContract $repository
     */
    public function __construct(ClientUserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 検索条件に合致したデータを持つClientUserモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollection(array $searchConditions): Collection
    {
        return $this->repository->fetchAll($searchConditions)->keyBy('id');
    }

    /**
     * 検索条件に合致したデータを持つClientUserモデルをページネーターとして取得する。
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
     * 単一の企業ユーザー情報を登録する。
     * @param  array $params
     * @return \App\Common\ClientUser\Model\ClientUser
     * @throws \Throwable
     */
    public function storeModel(array $params): ClientUser
    {
        return DB::transaction(function () use ($params) {
            return $this->repository->store($params);
        });
    }

    /**
     * 単一の企業ユーザー情報を更新する。
     * @param  \App\Common\ClientUser\Model\ClientUser $clientUser
     * @param  array<string, mixed> $params
     * @return void
     * @throws \Throwable
     */
    public function updateModel(ClientUser $clientUser, array $params): void
    {
        DB::transaction(function () use ($clientUser, $params) {
            $this->repository->update($clientUser, $params);
        });
    }

    /**
     * 単一の企業ユーザー情報を削除する。
     * @param  \App\Common\ClientUser\Model\ClientUser $clientUser
     * @return void
     * @throws \Throwable
     */
    public function deleteModel(ClientUser $clientUser): void
    {
        DB::transaction(function () use ($clientUser) {
            $this->repository->delete($clientUser);
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
