<?php
namespace App\Common\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

/**
 * メンテナンスモード中にアクセス可能な状態を制御するミドルウェア。
 * @package \App\Common\Http
 */
class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * メンテナンスモード中でもアクセス可能なURIの定義。
     * @var array<int, string>
     */
    protected $except = [];
}
