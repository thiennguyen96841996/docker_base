<?php
namespace App\Common\Broadcasting\Provider;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * ブロードキャストサービスの登録や設定を行うクラス。
 * @package \App\Common\Broadcasting
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * サービスを起動する。
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();
    }
}
