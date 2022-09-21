<?php
namespace GLC\Customer\Exception;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use GLC\Platform\Exception\Contracts\Handler as HandlerContract;
use GLC\Platform\Exception\Functions;
use Throwable;

/**
 * アプリケーションに合わせた例外処理を行うクラス。
 *
 * @package GLC\Master\Exception
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class Handler implements HandlerContract
{
    use Functions;

    /**
     * 認証例外を処理する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Illuminate\Auth\AuthenticationException $e AuthenticationExceptionオブジェクト
     * @return \Symfony\Component\HttpFoundation\Response|null Responseオブジェクト or null
     */
    public function unauthenticated(Request $request, AuthenticationException $e): ?Response
    {
        if (in_array(config('auth.defaults.guard'), $e->guards())) {
            return redirect()->guest(route(config('auth.routes.name.guest', '/')));
        }

        Log::channel('critical')->critical('Reached not predicted process. please check.');
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
        if (View::exists($view = "customer.errors.{$e->getStatusCode()}")) {
            if ($e->getStatusCode() == 503) {
                return response()->view($view, ['message' => $e->getMessage()], 503);
            }
            return $this->makeViewResponse($view, $e);
        } else if (View::exists($view = 'customer.errors.system')) {
            return $this->makeViewResponse($view, $e);
        }
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
        return null;
    }
}