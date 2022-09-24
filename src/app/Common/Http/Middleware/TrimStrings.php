<?php
namespace App\Common\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

/**
 * 各リクエストデータの前後の空白を自動的に取り除くミドルウェア。
 * @package \App\Common\Http
 */
class TrimStrings extends Middleware
{
    /**
     * 空白のトリミングを行わないパラメーターの定義
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
