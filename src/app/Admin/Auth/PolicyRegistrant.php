<?php
namespace App\Admin\Auth;

use App\Common\Auth\Contract\PolicyRegistrant as PolicyRegistrantContract;

/**
 * 各環境毎のポリシーを登録するクラス。
 * @package \App\Admin\Auth
 */
class PolicyRegistrant implements PolicyRegistrantContract
{
    /**
     * ポリシーとそれに対応するモデルのマッピングの定義。
     * @var array<class-string, class-string>
     */
    private array $policies = [
        \App\Common\AdminUser\Model\AdminUser::class   => \App\Admin\AdminUser\Policy\AdminUserPolicy::class,
        \App\Common\ClientUser\Model\ClientUser::class => \App\Admin\ClientUser\Policy\ClientUserPolicy::class,
    ];

    /**
     * 登録したいポリシーの配列を取得する。
     * ※ 引数で渡された配列とマージしたものを返す。
     * @param  array<class-string, class-string> $defaultPolicies
     * @return array<class-string, class-string>
     */
    public function getPolicies(array $defaultPolicies): array
    {
        return collect($defaultPolicies)->union($this->policies)->all();
    }
}
