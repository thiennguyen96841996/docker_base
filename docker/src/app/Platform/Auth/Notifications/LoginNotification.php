<?php
namespace GLC\Platform\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use GLC\Platform\Notification\NotificationMailable;

/**
 * ログイン完了時の通知クラス。
 *
 * @package GLC\Platform\Auth\Notifications
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class LoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * IPアドレスを保持する変数。
     * @var string
     */
    private string $ip;

    /**
     * ユーザーエージェントを保持する変数。
     * @var string
     */
    private string $userAgent;

    /**
     * ログイン日時を保持する変数。
     * @var string
     */
    private string $date;

    /**
     * パスワード変更画面のURLを保持する変数。
     * @var string
     */
    private string $editUrl;

    /**
     * fromアドレスを保持する変数。
     * @var string
     */
    private string $from;

    /**
     * LoginNotification constructor.
     *
     * @param string ip アクセス元IPアドレス
     * @param string userAgent ユーザーエージェント
     * @param string $date ログイン日時
     * @param string $editUrl パスワード変更画面のURL
     * @param string $from fromアドレス
     */
    public function __construct(string $ip, string $userAgent, string $date, string $editUrl, string $from)
    {
        $this->ip         = $ip;
        $this->userAgent  = $userAgent;
        $this->date       = $date;
        $this->editUrl    = $editUrl;
        $this->from       = $from;
    }

    /**
     * 通知するチャネルを取得する。
     *
     * @return array
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
            ->subject('ログイン通知')
            ->to($notifiable->routeNotificationForMail())
            ->from($this->from)
            ->text('platform.mail.login-notification', [
                'date'      => $this->date,
                'ip'        => $this->ip,
                'userAgent' => $this->userAgent,
                'editUrl'   => $this->editUrl,
            ]);
    }
}