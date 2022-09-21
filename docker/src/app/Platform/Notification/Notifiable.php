<?php
namespace GLC\Platform\Notification;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Contracts\Notifications\Dispatcher;

/**
 * 通知を使用するModelクラスに適用する通知処理用のトレイト。
 *
 * @package GLC\Platform\Notification
 * @author  TinhNC <tinhhang22@gmail.com>
 */
trait Notifiable
{
    /**
     * 通知を行う。
     *
     * @param  \Illuminate\Notifications\Notification $instance Notificationオブジェクト
     * @return void
     */
    public function notify(Notification $instance)
    {
        app(Dispatcher::class)->send($this, $instance);
    }

    /**
     * 即座に通知を行う。
     *
     * @param  \Illuminate\Notifications\Notification $instance Notificationオブジェクト
     * @param  array|null $channels 通知先のチャネル
     * @return void
     */
    public function notifyNow(Notification $instance, array $channels = null)
    {
        app(Dispatcher::class)->sendNow($this, $instance, $channels);
    }

    /**
     * ドライバーに応じて必要な値を返す。
     *
     * @param  string $driver ドライバーの名称
     * @param  \Illuminate\Notifications\Notification|null $notification Notificationオブジェクト
     * @return mixed
     */
    public function routeNotificationFor(string $driver, $notification = null): mixed
    {
        if (method_exists($this, $method = 'routeNotificationFor' . Str::studly($driver))) {
            return $this->{$method}($notification);
        }

        /*
         * 上記の処理を見るとわかるようにクラスにメソッドを作成することで、
         * 使用するドライバーに合わせた値を返せる。
         * 見通しを良くするために、あえて各Modelクラスにメソッドを作成する方法を取る。
         */
        return null;
    }
}