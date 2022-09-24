<?php
namespace App\Common\AdminUser\Service;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Common\AdminUser\Contract\AdminUserRepository as AdminUserRepositoryContract;
use App\Common\AdminUser\Model\AdminUser;

/**
 * 企業ユーザー情報に関連する処理を行うクラス。
 * @package \App\Common\AdminUser
 */
class AdminUserService
{
    /**
     * AdminUserモデルのデータ操作を扱うクラス。
     * @var \App\Common\AdminUser\Repository\AdminUserRepository
     */
    private AdminUserRepositoryContract $repository;

    /**
     * constructor.
     * @param AdminUserRepositoryContract $repository
     */
    public function __construct(AdminUserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 検索条件に合致したデータを持つAdminUserモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollection(array $searchConditions): Collection
    {
        return $this->repository->fetchAll($searchConditions)->keyBy('id');
    }

    /**
     * 検索条件に合致したデータを持つAdminUserモデルをページネーターとして取得する。
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
     * @return \App\Common\AdminUser\Model\AdminUser
     * @throws \Throwable
     */
    public function storeModel(array $params): AdminUser
    {
        return DB::transaction(function () use ($params) {
            return $this->repository->store($params);
        });
    }

    /**
     * 単一の管理ユーザー情報を更新する。
     * @param  \App\Common\AdminUser\Model\AdminUser $adminUser
     * @param  array<string, mixed> $params
     * @return void
     * @throws \Throwable
     */
    public function updateModel(AdminUser $adminUser, array $params): void
    {
        DB::transaction(function () use ($adminUser, $params) {
            $this->repository->update($adminUser, $params);
        });
    }

    /**
     * 単一の管理ユーザー情報を削除する。
     * @param  \App\Common\AdminUser\Model\AdminUser $adminUser
     * @return void
     * @throws \Throwable
     */
    public function deleteModel(AdminUser $adminUser): void
    {
        DB::transaction(function () use ($adminUser) {
            $this->repository->delete($adminUser);
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
