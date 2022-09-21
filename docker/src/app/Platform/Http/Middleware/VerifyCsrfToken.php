<?php
namespace GLC\Platform\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * CSRFを防ぐためのトークンをチェックする為のミドルウェアクラス。
 *
 * @package GLC\Platform\Http\Middleware
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * XSRF-TOKENクッキーをレスポンスに追加するかどうか
     * @var array
     */
    protected $addHttpCookie = true;

    /**
     * CSRFのチェックを行わないURIの定義。
     * @var array
     */
    protected $except = [];
}