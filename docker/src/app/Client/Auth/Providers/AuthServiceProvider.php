<?php
namespace GLC\Client\Auth\Providers;

use GLC\Platform\Auth\Providers\AbsPackageServiceProvider as ServiceProvider;

/**
 * Authパッケージを使用するのに必要な処理を行うプロバイダークラス。
 * 基本となる\Illuminate\Auth\AuthServiceProviderを継承し、Auth機能を状況によって変更可能にしている。
 * また、標準的なアプリケーション用のAuthServiceProviderの機能も持つ。
 *
 * @package GLC\Client\Auth\Providers
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
                'authenticated'  => 'client.top.index',
                'guest'          => 'client.login.index',
                'password_edit'  => 'client.password.index',
                'password_reset' => 'client.password.reset.edit'
            ]
        ];
    }
}