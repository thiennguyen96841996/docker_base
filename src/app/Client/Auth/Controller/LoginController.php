<?php
namespace App\Client\Auth\Controller;

use Throwable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Common\Http\Controller\AbsController;
use App\Common\ClientUser\Service\ClientUserService;
use App\Client\Auth\Request\LoginRequest;

/**
 * ログインに関連するリクエストを処理するクラス。
 * @package \App\Client\Auth
 */
class LoginController extends AbsController
{
    /**
     * 管理ユーザー情報に関連する処理を行うクラス。
     * @var \App\Common\ClientUser\Service\ClientUserService
     */
    private ClientUserService $service;

    /**
     * constructor.
     */
    public function __construct(ClientUserService $service)
    {
        $this->middleware('guest')->except('logout');
        $this->service = $service;
    }

    /**
     * ログイン画面を表示する。
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('login.index');
    }

    /**
     * ログインする。
     * @param  \App\Client\Auth\Request\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        /** @var \App\Common\ClientUser\Model\ClientUser $user */
        $user = Auth::user();
        try {
            $this->service->updateLastLoginDate($user->getAttribute('email'));
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }

        // 前の画面に戻す
        return redirect()->intended(route(config('auth.authenticated_route_name','home')));
    }

    /**
     * ログアウトする。
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); // CSRF

        return redirect(route(config('auth.guest_route_name','login')));
    }
}
