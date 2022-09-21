<?php
namespace GLC\Master\Auth\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use GLC\Platform\User\Definitions\UserDefs;
use Throwable;
use GLC\Master\Http\Controllers\AbsBaseController as BaseController;
use GLC\Platform\Auth\Contracts\AuthRepository as RepositoryContract;
use GLC\Master\Auth\Forms\LoginRequest;

/**
 * ログイン / ログアウトに関連した処理を行うコントローラークラス。
 *
 * @package GLC\Master\Auth\Controllers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class LoginController extends BaseController
{
    use AuthenticatesUsers;

    /**
     * 認証に関連した処理を行うリポジトリクラス。
     * @var RepositoryContract
     */
    protected RepositoryContract $repository;

    /**
     * LoginController Constructor.
     *
     * @param  RepositoryContract $repository 認証に関連した処理を行うリポジトリクラス
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(RepositoryContract $repository)
    {
        parent::__construct();

        $this->middleware('guest:' . config('auth.defaults.guard'))->except('logout');
        $this->repository = $repository;
    }

    /**
     * ログイン画面を表示する。
     *
     * @return \Illuminate\Contracts\View\View Viewオブジェクト
     */
    public function showLoginForm(): View
    {
        return view(Route::currentRouteName());
    }

    /**
     * ログイン処理を行う。
     *
     * @param  \GLC\Master\Auth\Forms\LoginRequest $request LoginRequestオブジェクト
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse|null Responseオブジェクト or null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        $this->sendFailedLoginResponse($request);
        return null;
    }

    /**
     * 認証完了時の処理を行う。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \GLC\Platform\Auth\Models\AuthUser $user Userオブジェクト
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function authenticated(Request $request, $user)
    {
        try {
            $this->repository->updateLastLoginAt($user);
        } catch (Throwable $thw) {
            Log::channel('error')->error($thw->getMessage());
        }

        $user->sendLoginSuccessNotification($request);

        $this->trace(TracerDefs::PATH_CATEGORY_ACTION_LOG, [
            'log_no'   => TracerDefs::ACTION_LOG_NO_MASTER_LOGIN,
            'tool'     => TracerDefs::TOOL_NAME_MASTER,
            'user_id'  => Auth::user()->id,
            'ip'       => $request->ip(),
            'datetime' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * ログイン失敗した時の応答インスタンスを取得する。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => 'ログインID、パスワードが間違っています。',
        ]);
    }

    /**
     * ログアウト処理を行う。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @return \Illuminate\Http\RedirectResponse RedirectResponseオブジェクト
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->trace(TracerDefs::PATH_CATEGORY_ACTION_LOG, [
            'log_no'   => TracerDefs::ACTION_LOG_NO_MASTER_LOGOUT,
            'tool'     => TracerDefs::TOOL_NAME_MASTER,
            'user_id'  => Auth::user()->id,
            'ip'       => $request->ip(),
            'datetime' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route(config('auth.routes.name.guest')));
    }

    /**
     * 認証に使用するGuardを取得する。
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard StatefulGuardを実装したオブジェクト
     */
    protected function guard(): StatefulGuard
    {
        return Auth::guard(config('auth.defaults.guard'));
    }

    /**
     * リダイレクト先のURLを取得する。
     *
     * @return string リダイレクト先のURL
     */
    protected function redirectTo(): string
    {
        if (Auth::user()->role === UserDefs::ROLE_CODE_AGENT) {
            return route(config('auth.routes.name.authenticated_role_agent'));
        }
        return route(config('auth.routes.name.authenticated'));
    }

    /**
     * ログインに使用するカラムを取得する。
     *
     * @return string
     */
    public function username()
    {
        return 'id';
    }
}