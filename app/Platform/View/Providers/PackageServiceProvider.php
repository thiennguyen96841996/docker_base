<?php
namespace GLC\Platform\View\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use GLC\Platform\View\Contracts\Renderer as RendererContract;
use GLC\Platform\View\Renderer;

/**
 * Viewパッケージを使用するのに必要な処理を行うプロバイダークラス。
 *
 * @package GLC\Platform\View\Providers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class PackageServiceProvider extends ServiceProvider implements DeferrableProvider
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