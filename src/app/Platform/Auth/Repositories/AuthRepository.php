<?php
namespace GLC\Platform\Auth\Repositories;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use GLC\Platform\Auth\Contracts\AuthRepository as RepositoryContract;
use GLC\Platform\Auth\Models\LoginHistory;
use GLC\Platform\Auth\Notifications\ResetPasswordNotification;
use GLC\Platform\Database\Definitions\DatabaseDefs;
use GLC\Platform\Employee\Models\Employee;
use GLC\Platform\Repository\ViewModelRepositoryTrait;
use GLC\Platform\User\Models\User;

/**
 * 認証に関連した処理を行うリポジトリクラス。
 *
 * @package GLC\Platform\Auth\Repositories
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class AuthRepository implements RepositoryContract
{
    use ViewModelRepositoryTrait;

    /**
     * 最終ログイン日時を更新する。
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user プラットフォームユーザーの認証モデルクラス
     * @return void
     * @throws \Throwable
     */
    public function updateLastLoginAt(Authenticatable $user)
    {
        /** @var \GLC\Platform\Auth\Models\AuthUser $user */
        DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE)->transaction(function () use ($user) {
            unset($user->active_id);
            unset($user->ids);
            unset($user->shop_name);
            unset($user->group_id);

            $user->timestamps = false;
            $user->last_login_at = Carbon::now();
            $user->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE)->save();

            $user->timestamps = true;
        });
    }

    /**
     * パスワードを更新する。
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user プラットフォームユーザーの認証モデルクラス
     * @param  string $password パスワード
     * @return void
     * @throws \Throwable
     */
    public function updatePassword(Authenticatable $user, string $password)
    {
        DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE)->transaction(function () use ($user, $password) {
            $user->password                 = Hash::make($password);
            $user->last_password_updated_at = Carbon::now();
            $user->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE)->save();
        });
    }



}