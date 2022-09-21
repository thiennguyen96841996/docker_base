<?php
namespace GLC\Platform\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

/**
 * 信頼できるホストからのアクセスを許可する為のミドルウェアクラス。
 *
 * @package GLC\Platform\Http\Middleware
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class TrustHosts extends Middleware
{
    /**
     * 信頼できるホスト名のパターンの定義。
     * @return array
     */
    public function hosts()
    {
        return [
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}