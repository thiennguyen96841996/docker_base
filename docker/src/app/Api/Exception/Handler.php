<?php
namespace GLC\Api\Exception;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use GLC\Platform\Exception\Contracts\Handler as HandlerContract;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * アプリケーションに合わせた例外処理を行うクラス。
 *
 * @package GLC\Api\Exception
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class Handler implements HandlerContract
{
    /**
     * 認証例外を処理する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Illuminate\Auth\AuthenticationException $e AuthenticationExceptionオブジェクト
     * @return \Symfony\Component\HttpFoundation\Response|null Responseオブジェクト or null
     */
    public function unauthenticated(Request $request, AuthenticationException $e): ?Response
    {
        return null;
    }

    /**
     * HTTP例外に対応したViewを含むレスポンスを返す。
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e HttpExceptionInterfaceを実装した例外オブジェクト
     * @return \Symfony\Component\HttpFoundation\Response|null Responseオブジェクト or null
     */
    public function renderHttpException(HttpExceptionInterface $e): ?Response
    {
        return null;
    }

    /**
     * 例外のJSONレスポンスを準備する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Throwable $e Throwableオブジェクト
     * @return \Illuminate\Http\JsonResponse|null JsonResponseオブジェクト or null
     */
    public function prepareJsonResponse(Request $request, Throwable $e): ?JsonResponse
    {
        // ステータスコードを取得する
        $statusCode = $e instanceOf HttpExceptionInterface ? $e->getStatusCode() : 0;

        //メンテナンス時
        if ($statusCode == 503) {
            return new JsonResponse(
                $e->getMessage(),
                503,
                $e instanceOf HttpExceptionInterface ? $e->getHeaders() : [],
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            );
        }
        // APIでは詳細なエラーメッセージは返さない
        if ($request->is('api/*')) {
            return new JsonResponse(
                'ERROR',
                500,
                $e instanceOf HttpExceptionInterface ? $e->getHeaders() : [],
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            );
        }
        return null;
    }

    /**
     * バリデーションエラーをJSONレスポンスに変換する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Illuminate\Validation\ValidationException $exception 例外オブジェクト
     * @return \Illuminate\Http\JsonResponse|null JsonResponseオブジェクト or null
     */
    public function invalidJson(Request $request, ValidationException $exception): ?JsonResponse
    {
        // APIでは400に固定
        if ($request->is('api/*')) {
            return response()->json([
                'message' => $exception->getMessage(),
                'errors'  => $exception->errors(),
            ], 400);
        }

        return null;
    }
}