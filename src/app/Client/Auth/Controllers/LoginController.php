<?php
namespace GLC\Client\Auth\Controllers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Throwable;
use GLC\Client\Http\Controllers\AbsBaseController as BaseController;
use GLC\Platform\Auth\Contracts\AuthRepository as RepositoryContract;
use GLC\Client\Auth\Forms\LoginRequest;

/**
 * ログイン / ログアウトに関連した処理を行うコントローラークラス。
 *
 * @package GLC\Client\Auth\Controllers
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
     * ログイン履歴に関連した処理を行うリポジトリクラス
     * @var LoginHistoryRepositoryContract
     */
    protected LoginHistoryRepositoryContract $historyRepository;

    /**
     * 担当者に関連した処理を行うリポジトリクラス。
     * @var EmployeeAccountRepositoryContract
     */
    protected EmployeeAccountRepositoryContract $employeeAccountRepository;

    /**
     * LoginController Constructor.
     *
     * @param  RepositoryContract $repository 認証に関連した処理を行うリポジトリクラス
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(RepositoryContract $repository,
    ) {
        parent::__construct();

        $this->middleware('guest:' . config('auth.client.guard'))->except(['logout', 'history']);

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
     * @param  \GLC\Client\Auth\Forms\LoginRequest $request LoginRequestオブジェクト
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

        // ログイン成功時
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // ログイン失敗時
        $this->incrementLoginAttempts($request);
        $this->sendFailedLoginResponse($request);
        return null;
    }

    /**
     * Redirect the user after determining they are locked out.(オーバーライド）
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            'lock' => [trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }

    /**
     * 認証完了時の処理を行う。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  \GLC\Platform\Auth\Models\AuthEmployee $user Userオブジェクト
     * @return \Illuminate\Contracts\Foundation\Application|RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function authenticated(Request $request, $user)
    {
        try {
            $this->repository->updateLastLoginAt($user);


        } catch (Throwable $thw) {
            Log::channel('error')->error($thw->getMessage());
        }

        // last_password_updated_atがnullならパスワード変更画面にリダイレクト
        if (is_null($user->last_password_updated_at)) {
            $request->session()->flash(
                'errors',
                (new ViewErrorBag())->put('default', new MessageBag([ 'status' => 'パスワードを変更してください']))
            );
            return redirect(route('client.password.index'));
        }

        // 紐づくアカウント情報を取得
        $accounts = array_map(
            function ($acocunt) {
                return $acocunt['shop_id'];
            }, $this->employeeAccountRepository->getCollection([
                'employee_id' => $user->id,
                'active_account' => true,
            ])->toArray()
        );

        if (count($accounts) === 1) {
            $user = Auth::guard(config('auth.client.guard'))->user();

            $this->employeeAccountRepository->updateActiveAccount($user->id, $accounts[0]);

            $this->historyRepository->store($user, $request, $accounts[0]);

        } else {
            return redirect(route('client.top.multi'));
        }
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
        return Auth::guard(config('auth.client.guard'));
    }

    /**
     * リダイレクト先のURLを取得する。
     *
     * @return string リダイレクト先のURL
     */
    protected function redirectTo(): string
    {
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

    /**
     * history
     *
     * @param Request $request
     * @return View
     */
    public function history(Request $request): View
    {
        $conditions = [
            'employee_id' => Auth::user()->id,
            'shop_id'    => Auth::user()->active_id,
        ];

        $this->renderer->setPageTitle('ログイン履歴');

        $this->renderer->setPaginator(
            $this->historyRepository->getViewModelPaginator(
                route(Route::currentRouteName()),
                $this->getRequestedPage($request),
                $conditions
            )
        );

        return view(Route::currentRouteName());
    }
}