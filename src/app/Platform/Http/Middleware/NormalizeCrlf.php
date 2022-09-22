<?php
namespace GLC\Platform\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * リクエストの入力に含まれる改行文字の値を"\n"に正規化するミドルウェアクラス。
 *
 * @package GLC\Platform\Http\Middleware
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class NormalizeCrlf
{
    /**
     * リクエストの入力に含まれる改行文字の値を"\n"に正規化する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Closure $next 次のMiddlewareの処理
     * @return \Illuminate\Http\RedirectResponse|\Closure RedirectResponseオブジェクト or 次のMiddlewareの処理
     */
    public function handle(Request $request, Closure $next)
    {
        $replace = [];
        foreach ($request->input() as $key => $value) {
            $replace[$key] = $this->convertInput($value);
        }
        $request->replace($replace);

        return $next($request);
    }

    /**
     * リクエストの入力値を変換する。
     *
     * @param  mixed $value 変換したい値
     * @return array|string|null 変換された値
     */
    private function convertInput(mixed $value)
    {
        // ネストされた値を処理する。
        if (is_array($value)) {
            $container = [];
            foreach ($value as $childKey => $child) {
                $container[$childKey] = $this->convertInput($child);
            }
            return $container;
        }
        return preg_replace(['/\r\n/','/\r/','/\n/'], "\n", $value);
    }
}