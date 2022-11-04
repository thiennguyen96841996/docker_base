<?php
namespace App\Admin\ClientUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Common\Notification\MailNotification;
use App\Common\ClientUser\ViewModel\ClientUserViewModel;

/**
 * SendPassword通知クラス
 *
 * @package App\Admin\ClientUser\Notification
 */
class SendPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var ClientUserViewModel
     */
    private ClientUserViewModel $clientUserViewModel;

    private string $password;

    /**
     * SendPassword constructor.
     * @param ClientUserViewModel                $clientUserViewModel
     */
    public function __construct(ClientUserViewModel $clientUserViewModel, string $password)
    {
        $this->clientUserViewModel       = $clientUserViewModel;
        $this->password                  = $password;
    }

    /**
     * 通知するチャネルを取得する
     *
     * @return array 通知するチャネルの配列
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * メールを作成する
     * https://qiita.com/hisash/items/44db12c58d5683db25dd
     * テキストメールを送信するためMailMessageではなくMailableを利用する
     *
     * @param mixed $notifiable
     * @return MailNotification
     *
     * ※ Mailable Objectをリターン可能
     * https://readouble.com/laravel/5.7/en/notifications.html
     */
    public function toMail(mixed $notifiable) : MailNotification
    {
        return (new MailNotification())
            ->subject('【重要】Glc send password')
            ->to($notifiable->email)
            ->text('mail.send-password', [
                'email'  => $this->clientUserViewModel->email,
                'password'  => $this->password
            ]);
    }
}
