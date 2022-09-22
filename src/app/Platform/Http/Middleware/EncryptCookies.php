<?php
namespace GLC\Platform\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

/**
 * クッキーを暗号化する為のミドルウェアクラス。
 *
 * @package GLC\Platform\Http\Middleware
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class EncryptCookies extends Middleware
{
    /**
     * 暗号化したくないクッキーデータのキーの定義。
     * @var array
     */
    protected $except = [];
}