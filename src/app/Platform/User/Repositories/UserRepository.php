<?php
namespace GLC\Platform\User\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GLC\Platform\Database\Definitions\DatabaseDefs;
use GLC\Platform\User\Contracts\UserRepository as RepositoryContract;
use GLC\Platform\User\Models\User;
use GLC\Platform\User\Notifications\OpenAccount;
use GLC\Platform\User\Notifications\PasswordChange;
use GLC\Platform\User\ViewModels\UserViewModel;
use GLC\Platform\Repository\ViewModelRepositoryTrait;

/**
 * Userモデルに関連した処理を行うリポジトリクラス。
 *
 * @package GLC\Platform\User\Repositories
 * @author  Odo Ari <flasanpal@yahoo.co.jp>
 */
class UserRepository implements RepositoryContract
{
    use ViewModelRepositoryTrait;

    /**
     * UserRepository constructor.
     *
     */
    public function __construct()
    {
    }

    /**
     * 検索条件に合致したデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Support\Collection|null UserのCollectionオブジェクト or null
     * @throws \Throwable
     */
    public function getCollection(array $searchConditions = [], $connectionWrite = false): ?Collection
    {
        if ($connectionWrite) {
            $builder = User::on(DatabaseDefs::CONNECTION_NAME_WRITE);
        } else {
            $builder = User::on(DatabaseDefs::CONNECTION_NAME_READ);
        }
        /** @var User $builder */
        $builder
            ->addSelect([
                '*'
            ]);

        return $builder->whereMultiConditions($searchConditions)->get();
    }

    /**
     * 検索条件に合致した単一のデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return User|null Userオブジェクト or null
     * @throws \Throwable
     */
    public function getModel(array $searchConditions, $connectionWrite = false): ?User
    {
        $collection = $this->getCollection($searchConditions, $connectionWrite);

        return $collection->count() === 1 ? $collection->first(): null;
    }

    /**
     * ViewModelオブジェクトのコレクションとしてデータを取得する。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Support\Collection|null ViewModelContractを実装するクラスのコレクション or null
     * @throws \Throwable
     */
    public function getViewModelCollection(array $searchConditions = []): ?Collection
    {
        return $this->makeViewModels($this->getCollection($searchConditions));
    }

    /**
     * 単一のViewModelオブジェクトとしてデータを取得する。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \GLC\Platform\User\ViewModels\UserViewModel|null UserViewModelオブジェクト or null
     * @throws \Throwable
     */
    public function getViewModel(array $searchConditions): ?UserViewModel
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $this->makeViewModel($collection->first()): null;
    }

    /**
     * ViewModelのデータをPaginatorとして取得する。
     *
     * @param  string $path URLの元になるパス
     * @param  int $page ページ番号
     * @param  array $searchConditions 検索条件の配列
     * @param bool $writeConnection
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getViewModelPaginator(string $path, int $page, array $searchConditions = [], bool $writeConnection = false): LengthAwarePaginator
    {
        if ($writeConnection) {
            $builder = User::on(DatabaseDefs::CONNECTION_NAME_WRITE);
        } else {
            $builder = User::on(DatabaseDefs::CONNECTION_NAME_READ);
        }
        /** @var User $builder */
        $builder
            ->addSelect([
                '*'
            ])
            ->orderBy('updated_at', 'desc');

        $paginator = $builder->whereMultiConditions($searchConditions)->asPaginator($path, $page);

        return $paginator->setCollection($this->makeViewModels($paginator->getCollection()));
    }

    /**
     * ユーザー情報を登録する。
     *
     * @param array $storeData
     * @return string
     * @throws \Throwable
     */
    public function store(array $storeData): int
    {
        return DB::connection('mysql_write')->transaction(function () use($storeData) {
            $user  = new User();
            $user->name          = Arr::get($storeData, 'name');
            $user->email         = Arr::get($storeData, 'email');
            $user->password      = Hash::Make($password = makeRandomStrForPassword());
            $user->role          = Arr::get($storeData, 'role');
            $user->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE)->save();

            $user->password      = $password;
            $user->notify(new OpenAccount($user));

            return $user->id;
        });
    }

    /**
     * ユーザー情報を更新する
     * @param string $id
     * @param array $updateData
     * @return string|null
     * @throws \Throwable
     */

    public function update(User $user, array $updateData)
    {
        DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE)->transaction(function () use ($user, $updateData) {
            $user->id       = Arr::get($updateData, 'id');
            $user->name     = Arr::get($updateData, 'name');
            $user->email    = Arr::get($updateData, 'email');
            $user->role     = Arr::get($updateData, 'role');
            $user->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE)->save();
        });
    }

    /**
     * ユーザー情報を削除する。
     *
     * @param User $user
     * @throws \Throwable
     */
    public function destroy(User $user)
    {
        DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE)->transaction(function () use ($user) {
            $user->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE)->delete();
        });
    }

    /**
     * パスワードを更新する。
     *
     * @param Group $group
     * @param array $updateData
     */
    public function changePassword(User $user)
    {
        DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE)->transaction(function () use ($user) {
            $user->password                 = Hash::make($password = makeRandomStrForPassword());
            $user->last_password_updated_at = null;
            $user->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE)->save();

            $user->password = $password;
            $user->notify(new PasswordChange($user));
        });
    }

    /**
     * パスワードを更新する。TODO 使われてなさそう
     *
     * @param User $user
     * @param String $password
     */
    public function changePasswordFromApp(User $user, String $password)
    {
        $user->password                 = Hash::make($password);
        $user->last_password_updated_at = Carbon::now();
        $user->save();

        $user->password = $password;
//        $user->notify(new PasswordChange($user));
    }

    /**
     * メールアドレスがすでに登録されているか確認する
     *
     * @param string $email
     * @param string|null $id
     * @return bool
     */
    public function isAlreadyRegisteredEmail(string $email, string $id = null): bool
    {
        $searchCondition['email'] = $email;
        if (!empty($id)) {
            $searchCondition['not_id'] = $id;
        }
        /** @var User $builder */
        $builder = User::on(DatabaseDefs::CONNECTION_NAME_READ)
            ->addSelect([
                'users.id'
            ]);

        return $builder->whereMultiConditions($searchCondition)->count() !== 0;
    }
}