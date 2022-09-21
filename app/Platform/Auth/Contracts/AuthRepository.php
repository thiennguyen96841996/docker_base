<?php
namespace GLC\Platform\Auth\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * 認証に関連した処理を行うリポジトリクラスを表すインターフェイス。
 *
 * @package GLC\Platform\Auth\Contracts
 * @author  TinhNC <tinhhang22@gmail.com>
 */
interface AuthRepository
{
    /**
     * 最終ログイン日時を更新する。
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user 認証モデルクラス
     * @return void
     * @throws \Throwable
     */
    public function updateLastLoginAt(Authenticatable $user);

    /**
     * パスワードを更新する。
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user 認証モデルクラス
     * @param  string $password パスワード
     * @return void
     * @throws \Throwable
     */
    public function updatePassword(Authenticatable $user, string $password);
}