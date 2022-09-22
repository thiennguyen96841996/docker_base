<?php
namespace GLC\Platform\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

/**
 * 各リクエストデータの前後の空白を自動的に取り除く為のミドルウェアクラス。
 *
 * @package GLC\Platform\Http\Middleware
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class TrimStrings extends Middleware
{
    /**
     * 空白のトリミングを行わないパラメーターの定義
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];
}