<?php
namespace App\Client\Auth\Policy;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * すべてのポリシーの継承元となるクラス。
 * @package \App\Client\Auth
 */
abstract class AbsPolicy
{
    use HandlesAuthorization;

    /**
     * 事前認可チェックを実行する。
     * ※ nullを返した場合は該当ポリシーをチェックする。
     * @param  \Illuminate\Contracts\Auth\Authenticatable $authUser
     * @return bool|null
     */
    public function before(Authenticatable $authUser): ?bool
    {
        return null;
    }
}
