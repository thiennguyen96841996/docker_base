<?php
namespace App\Common\Auth\Contract;

/**
 * 各環境毎のポリシーを登録するクラスを表すインターフェイス。
 * @package \App\Common\Auth
 */
interface PolicyRegistrant
{
    /**
     * 登録したいポリシーの配列を取得する。
     * ※ 引数で渡された配列とマージしたものを返す。
     * @param  array<class-string, class-string> $defaultPolicies 共通で設定されているポリシーの配列
     * @return array<class-string, class-string>
     */
    public function getPolicies(array $defaultPolicies): array;
}
