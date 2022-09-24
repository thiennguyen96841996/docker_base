<?php
namespace App\Customer\Sample\Controller;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Common\Http\Controller\AbsController;

/**
 * ホーム画面に関連する処理を行うクラス。
 * @package \App\Customer\Home
 */
class SampleController extends AbsController
{
    /**
     * ホーム画面を表示する。
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $names = explode('.', Route::current()->getName());
        return view('sample.page'.Arr::last($names));
    }
}
