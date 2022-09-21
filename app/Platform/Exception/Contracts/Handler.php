<?php
namespace GLC\Platform\Exception\Contracts;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * アプリケーションに合わせた例外処理を行うクラスを表すインターフェイス。
 *
 * @package GLC\Platform\Exception\Contracts
 * @author  TinhNC <tinhhang22@gmail.com>
 */
interface Handler
{
    /**
     * 認証例外を処理する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Illuminate\Auth\AuthenticationException $e AuthenticationExceptionオブジェクト
     * @return \Symfony\Component\HttpFoundation\Response|null Responseオブジェクト or null
     */
    public function unauthenticated(Request $request, AuthenticationException $e): ?Response;

    /**
     * HTTP例外を処理する。
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e HttpExceptionInterfaceを実装した例外オブジェクト
     * @return \Symfony\Component\HttpFoundation\Response|null Responseオブジェクト or null
     */
    public function renderHttpException(HttpExceptionInterface $e): ?Response;

    /**
     * 例外のJSONレスポンスを準備する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Throwable $e Throwableオブジェクト
     * @return \Illuminate\Http\JsonResponse|null JsonResponseオブジェクト or null
     */
    public function prepareJsonResponse(Request $request, Throwable $e): ?JsonResponse;

    /**
     * バリデーションエラーをJSONレスポンスに変換する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Illuminate\Validation\ValidationException $exception 例外オブジェクト
     * @return \Illuminate\Http\JsonResponse|null JsonResponseオブジェクト or null
     */
    public function invalidJson(Request $request, ValidationException $exception): ?JsonResponse;
}