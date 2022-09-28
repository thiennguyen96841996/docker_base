<?php
namespace App\Common\View\Facades;

use Illuminate\Support\Facades\Facade;
use App\Common\View\Renderer as Real;

/**
 * RendererをFacade機能から使用するためのアクセッサークラス
 *
 * @package App\Common\View\Facades
 */
class Renderer extends Facade
{
    /**
     * 実体となるクラス名を取得する
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return Real::class;
    }
}
