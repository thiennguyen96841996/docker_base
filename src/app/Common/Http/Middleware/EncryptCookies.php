<?php
namespace App\Common\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

/**
 * クッキーを暗号化するミドルウェア。
 * @package \App\Common\Http
 */
class EncryptCookies extends Middleware
{
    /**
     * 暗号化したくないクッキーデータのキーの定義。
     * @var array<int, string>
     */
    protected $except = [];
}
