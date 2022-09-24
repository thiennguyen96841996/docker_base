<?php
namespace App\Common\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

/**
 * 信頼できるホストの設定を行うミドルウェア。
 * @package \App\Common\Http
 */
class TrustHosts extends Middleware
{
    /**
     * 信頼できるホストのパターンの定義。
     * @return array<int, string|null>
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function hosts()
    {
        return [
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
