<?php
namespace GLC\Master\Auth\Providers;

use GLC\Platform\Auth\Providers\AbsPackageServiceProvider as ServiceProvider;

/**
 * Authパッケージを使用するのに必要な処理を行うプロバイダークラス。
 * 基本となる\Illuminate\Auth\AuthServiceProviderを継承し、Auth機能を状況によって変更可能にしている。
 * また、標準的なアプリケーション用のAuthServiceProviderの機能も持つ。
 *
 * @package GLC\Master\Auth\Providers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * 認証用のルートを取得する。
     * @return array
     */
    protected function getAuthRoutes(): array
    {
        return [
            'name' => [
                'authenticated'  => 'master.entry.index',
                'guest'          => 'master.login.index',
                'password_edit'  => 'master.password.index',
                'password_reset' => 'master.password.reset.edit',
                'authenticated_role_agent'  => 'master.identificationCard.index',
            ]
        ];
    }
}