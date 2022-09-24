<?php
namespace App\Common\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Symfony\Component\HttpFoundation\Request;

/**
 * 信頼できるプロキシーの設定を行うミドルウェア。
 * @package \App\Common\Http
 */
class TrustProxies extends Middleware
{
    /**
     * 信頼できるプロキシーの定義。
     * @var array<int, string>|string|null
     */
    protected $proxies = '*'; //see: TrustProxies->setTrustedProxyIpAddresses()

    /**
     * プロキシーを特定する為に使用するヘッダー情報の定義。
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
