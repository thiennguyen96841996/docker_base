<?php
namespace GLC\Platform\Auth\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Http\Request;
use GLC\Platform\Auth\Notifications\ResetPasswordNotification;
use GLC\Platform\User\Models\User;

/**
 * ユーザーの情報を扱うモデルクラス。
 * 認証処理で使用する為のモデルとしての実装を持つ。
 *
 * @package GLC\Platform\Auth\Models
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class AuthUser extends User implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable;

    /**
     * パスワード再発行用のメールを送信するメールアドレスを取得する。
     *
     * @return string
     */
    public function getEmailForPasswordReset(): string
    {
        return $this->email;
    }

    /**
     * ログイン成功の情報を通知する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @return void
     */
    public function sendLoginSuccessNotification(Request $request)
    {
//        $this->notify(new LoginNotification(
//            $request->ip(),
//            $request->userAgent(),
//            $this->last_login_at->format('Y-m-d H:i:s'),
//            route(config('auth.routes.name.password_edit', '/')),
//            config('mail.from.address')
//        ));
    }

    /**
     * パスワード再発行の情報を通知する。
     *
     * @param  string $token 認証トークン
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification(
            url(route(config('auth.routes.name.password_reset'), [ 'token' => $token ], false)),
            config('mail.from.address')
        ));
    }
}