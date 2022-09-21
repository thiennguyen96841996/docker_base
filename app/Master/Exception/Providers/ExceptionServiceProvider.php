<?php
namespace GLC\Master\Exception\Providers;

use Illuminate\Support\ServiceProvider;
use GLC\Master\Exception\Handler;
use GLC\Platform\Exception\Contracts\Handler as HandlerContract;

/**
 * 例外処理に関連した設定を行うプロバイダークラス。
 *
 * @package GLC\Master\Exception\Providers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class ExceptionServiceProvider extends ServiceProvider
{
    /**
     * サービスの登録処理を行う。
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HandlerContract::class, function () {
            return new Handler();
        });
    }
}