<?php
namespace GLC\Platform\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use GLC\Platform\Employee\Definitions\EmployeeDefs;
use GLC\Platform\Notification\NotificationMailable;

/**
 * パスワード再発行時の通知クラス。
 *
 * @package GLC\Platform\Auth\Notifications
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * 送信対象のユーザーオブジェクト
     * @var Model
     */
    private Model $employee;
    private Model $corporation;

    /**
     * 仮パスワード
     * @var string
     */
    private string $password;

    /**
     * ResetPassword constructor.
     *
     * @param Model $model
     * @param string $password
     */
    public function __construct(Model $employee, Model $corporation, string $password)
    {
        $this->employee    = $employee;
        $this->corporation = $corporation;
        $this->password    = $password;
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
     * @param  mixed $notifiable Notifiableを実装したオブジェクト
     * @return \GLC\Platform\Notification\NotificationMailable
     */
    public function toMail(mixed $notifiable): NotificationMailable
    {
        return (new NotificationMailable())
            ->subject('【コノヒニ】パスワード再発行')
            ->to($notifiable->routeNotificationForMail())
            ->text('platform.mail.reset-password', [
                'id'               => EmployeeDefs::PREFIX. $this->employee->id,
                'employee_name'    => $this->employee->name,
                'corporation_name' => $this->corporation->name,
                'password'         => $this->password,
                'url'              => route('client.login.index'),
            ]);
    }
}