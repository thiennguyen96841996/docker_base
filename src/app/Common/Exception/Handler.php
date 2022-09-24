<?php
namespace App\Common\Exception;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\View;

/**
 * アプリケーションの例外処理を行うクラス。
 * @package \App\Common\Exception
 */
class Handler extends ExceptionHandler
{
    /**
     * 例外クラスとログレベルのマッピングの定義。
     * 該当しないものは\Psr\Log\LogLevel::ERRORとして処理される。
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [];

    /**
     * リポートする必要のない例外の定義。
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [];

    /**
     * バリデーション例外時にログ等に書き出さない入力値の定義。
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * 例外処理のリポートに対するコールバックを登録する。
     * ※ チェーンしてstop()を呼ぶか、falseを返すとログへの書き出しが行われない。
     * ※ $this->reportable()の第1引数に渡された例外に対して特定の処理を行いたい場合に使用出来る。
     * ※ Closureからレスポンスを返すとparent::renderViaCallbacks()により処理結果のレスポンスとして返却される。
     *   (つまりここで処理をオーバーライド出来るということ)
     * @return void
     */
    public function register()
    {
        //$this->reportable(function (Throwable $e) {
        //    return response()->view('errors.some-template', [], 500);
        //});
    }

    /**
     * エラー表示で使用するテンプレートが配置されているパスを登録する。
     * ※ isHttpResponse = ture もしくは app.debug = falseの場合に使用される。
     *   どちらでもない場合はignitionによるエラー画面が表示される。
     * @return void
     */
    protected function registerErrorViewPaths()
    {
        if (!empty($paths = config('speedy.view_error_paths'))) {
            View::replaceNamespace('errors', $paths);
        } else {
            parent::registerErrorViewPaths();
        }
    }

    /**
     * 認証例外を処理する。
     * ※ リダイレクト先の指定がない状態で投げられることもある為、オーバーライドしてリダイレクト先を指定している。
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @noinspection PhpMissingReturnTypeInspection
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->shouldReturnJson($request, $exception)
            ? response()->json([ 'message' => $exception->getMessage() ], 401)
            : redirect()->guest($exception->redirectTo() ?? route(config('auth.guest_route_name','login')));
    }
}
