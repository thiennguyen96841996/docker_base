<?php
namespace GLC\Platform\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\IpUtils;

/**
 * メンテナンス中のアクセスを防ぐ為のミドルウェアクラス。
 *
 * @package GLC\Platform\Http\Middleware;
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * メンテナンス中でもアクセス可能なURLの定義。
     *
     * @var array
     */
    protected $except = [];

    /**
     * Constructor
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance()) {
            $data = json_decode(file_get_contents($this->app->storagePath().'/framework/down'), true);

            if (isset($data['allowed']) && IpUtils::checkIp($request->ip(), (array) $data['allowed'])) {
                return $next($request);
            }

            throw new HttpException(503, $data['message'] ?? '503 Service Unavailable', null, []);
        }
        return $next($request);
    }
}