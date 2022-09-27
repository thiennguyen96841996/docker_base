<?php
namespace App\Common\View\Provider;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\View\Contract\Renderer as RendererContract;
use App\Common\View\Renderer;

/**
 * Viewパッケージを使用するのに必要な処理を行うプロバイダークラス。
 *
 * @package App\Common\View\Providers
 */
class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * サービスの登録処理を行う。
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RendererContract::class, function () {
            return new Renderer();
        });
    }

    /**
     * このクラスが提供するサービスの配列を返す。
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            RendererContract::class
        ];
    }
}
