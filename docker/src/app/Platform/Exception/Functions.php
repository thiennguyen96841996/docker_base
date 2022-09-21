<?php
namespace GLC\Platform\Exception;

use Illuminate\Support\ViewErrorBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * 例外処理を行うクラスで使用する共通関数を持つトレイト。
 *
 * @package GLC\Platform\Exception
 * @author  TinhNC <tinhhang22@gmail.com>
 */
trait Functions
{
    /**
     * Viewを使用したレスポンスを取得する。
     *
     * @param  string $viewPath 使用するViewのパス
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e
     * @return \Symfony\Component\HttpFoundation\Response Responseオブジェクト
     */
    protected function makeViewResponse(string $viewPath, HttpExceptionInterface $e): Response
    {
        return response()->view($viewPath, [
            'errors'           => new ViewErrorBag,
            'exception'        => $e,
        ], $e->getStatusCode(), $e->getHeaders());
    }
}