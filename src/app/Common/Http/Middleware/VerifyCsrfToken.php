<?php
namespace App\Common\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * CSRFを防ぐためのトークンをチェックするミドルウェア。
 * @package \App\Common\Http
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * CSRFのチェックを行わないURIの定義。
     * @var array<int, string>
     */
    protected $except = [];
}
