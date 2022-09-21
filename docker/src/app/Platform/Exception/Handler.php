<?php
namespace GLC\Platform\Exception;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;
use GLC\Platform\Exception\Contracts\Handler as HandlerContract;

/**
 * 例外を処理するクラス。
 *
 * @package GLC\Platform\Exception
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class Handler extends ExceptionHandler
{
    /**
     * リポートしなくてもよい例外の定義。
     * @var array
     */
    protected $dontReport = [
        //\GLC\Platform\Exceptions\Exception:class
    ];

    /**
     * 例外をリポートする。
     *
     * @param  Throwable $e 例外オブジェクト
     * @return void
     */
    public function report(Throwable $e)
    {
        // Validationのエラー
        if ($e instanceof ValidationException) {
            Log::channel('error')->error($e->errors());
        }

        if ($this->shouldntReport($e)) {
            return;
        }

        if (is_callable($reportCallable = [$e, 'report'])) {
            return $this->container->call($reportCallable);
        }

        // APIでエラーが発生した場合はヘッダー情報もログに出す
        if (request()->is('api/*')) {
            $path = request()->path();
            $platform = request()->header('platform');
            $deviceName = request()->header('device-name');
            $osVersion = request()->header('os-version');
            $appVersion = request()->header('app-version');
            $customerId = request()->header('customer-id');

            \Log::channel('error')->error("PATH: {$path}, PLATFORM: {$platform}, DEVICE_NAME: {$deviceName}, OS_VERSION: {$osVersion}, APP_VERSION: {$appVersion}, CUSTOMER_ID: {$customerId}");
        }

        Log::channel('error')->error($e);
    }

    /**
     * 例外をHTTPレスポンスにレンダリングする。
     * ※ 独自例外を実装する場合はココで処理をする。
     * ※ 親関数の中で処理が指定されていない例外はHttpException(Code:500)に変換して処理される。
     *
     * @param  \Illuminate\Http\Request $request リクエストオブジェクト
     * @param  \Exception $e 例外オブジェクト
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response Responseオブジェクト
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        return parent::render($request, $e);
    }

    /**
     * 認証例外を処理する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Illuminate\Auth\AuthenticationException $exception AuthenticationExceptionオブジェクト
     * @return \Symfony\Component\HttpFoundation\Response Responseオブジェクト
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if (!empty($handler = $this->getApplicationExceptionHandler()) && !empty($ret = $handler->unauthenticated($request, $exception))) {
            return $ret;
        }
         return parent::unauthenticated($request, $exception);
    }

    /**
     * HTTP例外を処理する。
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e HttpExceptionInterfaceを実装した例外オブジェクト
     * @return \Symfony\Component\HttpFoundation\Response Responseオブジェクト
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function renderHttpException(HttpExceptionInterface $e)
    {
        if (!empty($handler = $this->getApplicationExceptionHandler()) && !empty($ret = $handler->renderHttpException($e))) {
            return $ret;
        }
        return parent::renderHttpException($e);
    }

    /**
     * 例外のJSONレスポンスを準備する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Throwable $e Throwableオブジェクト
     * @return \Illuminate\Http\JsonResponse|null JsonResponseオブジェクト or null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function prepareJsonResponse($request, Throwable $e)
    {
        if (!empty($handler = $this->getApplicationExceptionHandler()) && !empty($ret = $handler->prepareJsonResponse($request, $e))) {
            return $ret;
        }
        return parent::prepareJsonResponse($request, $e);
    }

    /**
     * バリデーションエラーをJSONレスポンスに変換する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \Illuminate\Validation\ValidationException $exception 例外オブジェクト
     * @return \Illuminate\Http\JsonResponse|null JsonResponseオブジェクト or null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function invalidJson($request, ValidationException $exception): ?JsonResponse
    {
        if (!empty($handler = $this->getApplicationExceptionHandler()) && !empty($ret = $handler->invalidJson($request, $exception))) {
            return $ret;
        }
        return parent::invalidJson($request, $exception);
    }

    /**
     * アプリケーションに合わせた例外処理を行うクラスを取得する。
     *
     * @return \GLC\Platform\Exception\Contracts\Handler|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function getApplicationExceptionHandler(): ?HandlerContract
    {
        if (!empty($handler = app()->make(HandlerContract::class))) {
            return $handler;
        }
        return null;
    }
}