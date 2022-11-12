<?php
namespace App\Common\Http\Controller;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Common\View\Contract\Renderer as RendererContract;
use Illuminate\Support\Facades\View;

/**
 * すべてのコントローラーの継承元となるクラス。
 * @package \App\Common\Http
 */
abstract class AbsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Bladeから使用する描画系のサポートクラス。
     * @var RendererContract
     */
    protected RendererContract $renderer;

    /**
     * AbsBaseController constructor.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        // Bladeファイルから使用可能にする。
        $this->renderer = app()->make(RendererContract::class);
        View::share('renderer', $this->renderer);
    }

    /**
     * リクエストされたのページ番号を取得する。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @return int
     */
    protected function getRequestedPage(Request $request): int
    {
        return is_numeric($page = $request->get('page')) ? $page: 0;
    }
}
