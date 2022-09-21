<?php
namespace GLC\Platform\User\Notifications;

use Illuminate\Notifications\Notification;
use GLC\Platform\Notification\NotificationMailable;
use GLC\Platform\User\Models\User;

/**
 * パスワード更新の通知クラス。
 *
 * @package GLC\Platform\Authentication\Notifications
 * @author  Odo Ari <flasanpal@yahoo.co.jp>
 */
class PasswordChange extends Notification
{
    /**
     * 送信対象のユーザーオブジェクト
     * @var \GLC\Platform\User\Models\User
     */
    private User $user;

    /**
     * Open account constructor.
     *
     * @param \GLC\Platform\User\Models\User $user 送信対象のユーザーオブジェクト
     * @param string $password  仮パスワード
     */
    public function __construct(User $user)
    {
        $this->user  = $user;
    }

    /**
     * 通知するチャネルを取得する。
     *
     * @return array 通知するチャネルの配列
     */
    public function via(): array
    {
        return [ 'mail' ];
    }


    /**
     * メールを作成する。
     *
     * @param  mixed $notifiable
     * @return \GLC\Platform\Notification\NotificationMailable
     */
    public function toMail(mixed $notifiable): NotificationMailable
    {
        return (new NotificationMailable())
            ->subject('【コノヒニ】管理ツールID、仮パスワード送付')
            ->to($notifiable->email)
            ->text('platform.mail.change-password', [
                'id'          => $this->user->id,
                'name'        => $this->user->name,
                'password'    => $this->user->password,
                'url'         => url(route('master.login.index')),
            ]);
    }

}
