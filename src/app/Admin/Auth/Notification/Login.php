<?php
namespace App\Admin\Auth\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * ログイン時の通知メッセージ。
 * @package \App\Admin\Auth
 */
class Login extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * リクエストを送信してきたIPアドレス。
     * @var string
     */
    private string $ip;

    /**
     * ログインに成功した日時。
     * @var string
     */
    private string $date;

    /**
     * ログイン履歴画面のURL。
     * @var string
     */
    private string $url;

    /**
     * constructor.
     * @param string $ip
     * @param string $date
     * @param string $url
     */
    public function __construct(string $ip, string $date, string $url)
    {
        $this->ip   = $ip;
        $this->date = $date;
        $this->url  = $url;
    }

    /**
     * 通知するチャネルを取得する。
     * @return array
     */
    public function via(): array
    {
        return [ 'mail' ];
    }

    /**
     * メールを作成する。
     * @param  mixed $notifiable Notifiableを実装したオブジェクト
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('ログイン通知')
            ->from(config('mail.from.address'))
            ->markdown('mail.login', [
                'ip'   => $this->ip,
                'date' => $this->date,
                'url'  => $this->url,
            ]);
    }
}
