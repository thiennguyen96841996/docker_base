<?php
namespace App\Admin\ClientUser\Policy;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Common\ClientUser\Model\ClientUser;
use App\Admin\Auth\Policy\AbsPolicy;

/**
 * 認可チェックを行うクラス。
 * @package \App\Admin\ClientUser
 */
class ClientUserPolicy extends AbsPolicy
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
     * @param  \App\Common\ClientUser\Model\ClientUser $clientUser
     * @return bool
     */
    public function update(Authenticatable $authUser, ClientUser $clientUser): bool
    {
        return true;
    }

    /**
     * destroyメソッドの認可チェックを行う。
     * @param  \Illuminate\Contracts\Auth\Authenticatable $authUser
     * @param  \App\Common\ClientUser\Model\ClientUser $clientUser
     * @return bool
     */
    public function delete(Authenticatable $authUser, ClientUser $clientUser): bool
    {
        return true;
    }
}
