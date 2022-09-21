<?php
namespace GLC\Client\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use GLC\Platform\View\Contracts\Renderer as RendererContract;

/**
 * コントローラーの基底クラス。
 *
 * @package GLC\Master\Http\Controllers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
abstract class AbsBaseController extends BaseController
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

    /**
     * 行動履歴ログを登録する。
     *
     * @param  string $logPath
     * @param  array $appendix 付帯情報
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function trace(string $pathCategory, array $appendix = [])
    {
        $cloudDisk = Storage::disk(config('filesystems.cloud'));

        $now = Carbon::now();
        $logFilepath = $pathCategory.$now->format('Y-m').'/'.$now->format('Y-m-d').'.log';

        $cloudDisk->append($logFilepath,json_encode($appendix,JSON_UNESCAPED_SLASHES));

    }
}
