<?php
namespace GLC\Customer\Static\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\View;

/**
 * 静的コンテンツ処理を行うコントローラークラス。
 *
 * @package GLC\Master\Static\Controllers
 */
class StaticController extends BaseController
{
    /**
     * 利用規約
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function policy(): View
    {
        return view(Route::currentRouteName());
    }

    /**
     * 個人情報の取り扱い
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function privacy(): View
    {
        return view(Route::currentRouteName());
    }
}