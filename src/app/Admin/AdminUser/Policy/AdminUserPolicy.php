<?php
namespace App\Admin\AdminUser\Policy;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Common\AdminUser\Model\AdminUser;
use App\Admin\Auth\Policy\AbsPolicy;

/**
 * 認可チェックを行うクラス。
 * @package \App\Admin\AdminUser
 */
class AdminUserPolicy extends AbsPolicy
{
    /**
     * indexメソッドの認可チェックを行う。
     * @param  \Illuminate\Contracts\Auth\Authenticatable $authUser
     * @return bool
     */
    public function viewAny(Authenticatable $authUser): bool
    {
        return true;
    }

    /**
     * showメソッドの認可チェックを行う。
     * @param  \Illuminate\Contracts\Auth\Authenticatable $authUser
     * @return bool
     */
    public function view(Authenticatable $authUser): bool
    {
        return true;
    }

    /**
     * create/storeメソッドの認可チェックを行う。
     * @param  \Illuminate\Contracts\Auth\Authenticatable $authUser
     * @return bool
     */
    public function create(Authenticatable $authUser): bool
    {
        return true;
    }

    /**
     * edit/updateメソッドの認可チェックを行う。
     * @param  \Illuminate\Contracts\Auth\Authenticatable $authUser
     * @param  \App\Common\AdminUser\Model\AdminUser $adminUser
     * @return bool
     */
    public function update(Authenticatable $authUser, AdminUser $adminUser): bool
    {
        return true;
    }

    /**
     * destroyメソッドの認可チェックを行う。
     * @param  \Illuminate\Contracts\Auth\Authenticatable $authUser
     * @param  \App\Common\AdminUser\Model\AdminUser $adminUser
     * @return bool
     */
    public function delete(Authenticatable $authUser, AdminUser $adminUser): bool
    {
        return true;
    }
}
