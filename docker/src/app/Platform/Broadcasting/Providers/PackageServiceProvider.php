<?php
namespace GLC\Platform\Broadcasting\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

/**
 * ブロードキャスティングに関連した設定を行うプロバイダークラス。
 *
 * @package GLC\Platform\Broadcasting\Providers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class PackageServiceProvider extends ServiceProvider
{
    /**
     * サービスの起動処理を行う。
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        //require base_path('routes/channels.php');
    }
}