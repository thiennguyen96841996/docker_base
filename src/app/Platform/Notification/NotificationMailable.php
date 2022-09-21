<?php
namespace GLC\Platform\Notification;

use Illuminate\Mail\Mailable;

/**
 * 通知で使用するためのMailableを継承したクラス。
 *
 * @package GLC\Platform\Notification
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class NotificationMailable extends Mailable
{
    /**
     * 内容を作成する。
     *
     * @return void
     */
    public function build()
    {
    }
}