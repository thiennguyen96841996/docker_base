<?php
namespace GLC\Platform\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

/**
 * データ入力・編集時の確認画面から前の画面へ戻る為のリダイレクトを行うコントローラークラス。
 *
 * @package GLC\Platform\Http\Controllers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class FormRedirectController extends BaseController
{
    /**
     * 指定されたURLにリダイレクトする。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @return \Illuminate\Http\RedirectResponse リダイレクトレスポンス
     */
    public function redirect(Request $request): RedirectResponse
    {
        return redirect()->to($request->input('js_redirect_back_url', ''))->withInput($request->input());
    }
}