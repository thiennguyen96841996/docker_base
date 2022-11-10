<?php

namespace App\Admin\Home\Controller;

use Illuminate\View\View;
use App\Common\View\Facades\Renderer;
use App\Common\Http\Controller\AbsController;

/**
 * ホーム画面に関連する処理を行うクラス。
 * @package \App\Admin\Home
 */
class HomeController extends AbsController
{
    /**
     * ホーム画面を表示する。
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        Renderer::setPageTitle('Trang chủ');

        return view('home.index');
    }
}
