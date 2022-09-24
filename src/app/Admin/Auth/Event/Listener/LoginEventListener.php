<?php
namespace App\Admin\Auth\Event\Listener;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login as LoginEvent;
use App\Admin\Auth\Notification\Login;

/**
 * ログインイベントに対応したリスナー。
 * @package \App\Admin\Auth
 */
class LoginEventListener
{
    /**
     * イベントを処理する。
     * @param  \Illuminate\Auth\Events\Login $event
     * @return void
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function handle(LoginEvent $event): void
    {
        $event->user->notify(new Login(
            request()->ip(),
            Carbon::now()->format('Y/m/d H:i:s'), // TODO ログイン日時を$event->userから持ってきたい
            url('/login-history/')
        ));
    }
}
