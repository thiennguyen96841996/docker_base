<?php
namespace App\Client\Home\Controller;

use Illuminate\View\View;
use App\Common\Http\Controller\AbsController;

/**
 * ホーム画面に関連する処理を行うクラス。
 * @package \App\Client\Home
 */
class HomeController extends AbsController
{
    /**
     * ホーム画面を表示する。
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('home.index');
    }
}
