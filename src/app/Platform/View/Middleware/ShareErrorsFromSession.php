<?php
namespace GLC\Platform\View\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Middleware\ShareErrorsFromSession as Middleware;
use Throwable;
use GLC\Platform\View\Contracts\Renderer as RendererContract;

/**
 * バリデーションエラーをViewやRendererと共有するミドルウェアクラス。
 *
 * @package GLC\Platform\View\Middleware
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class ShareErrorsFromSession extends Middleware
{
    /**
     * 必要に応じてリクエストを処理する。
     *
     * @param  \Illuminate\Http\Request $request リクエストオブジェクト
     * @param  Closure $next 次のミドルウェアの処理
     * @return \Illuminate\Http\RedirectResponse|\Closure RedirectResponseオブジェクト or 次のMiddlewareの処理
     */
    public function handle($request, Closure $next)
    {
        $this->view->share(
            'errors', $errors = $request->session()->get('errors') ?: new ViewErrorBag
        );

        try {
            app()->make(RendererContract::class)->setValidationErrorMessageBag($errors);
        } catch (Throwable $thw) {
            Log::channel('fatal')->critical($thw->getMessage());
        }

        return $next($request);
    }
}