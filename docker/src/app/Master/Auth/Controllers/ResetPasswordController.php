<?php
namespace GLC\Master\Auth\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use GLC\Platform\User\Definitions\UserDefs;
use Throwable;
use GLC\Master\Http\Controllers\AbsBaseController as BaseController;
use GLC\Platform\Auth\Contracts\AuthRepository as RepositoryContract;
use GLC\Master\Auth\Forms\PasswordResetMailRequest;
use GLC\Master\Auth\Forms\PasswordResetRequest;

/**
 * パスワード再発行関連の処理を行うコントローラークラス。
 * \Illuminate\Foundation\Auth\SendsPasswordResetEmails と \Illuminate\Foundation\Auth\ResetsPasswordsの2つの実装を持つ。
 *
 * @package GLC\Master\Auth\Controllers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class ResetPasswordController extends BaseController
{
    /**
     * 認証に関連した処理を行うリポジトリクラス。
     * @var RepositoryContract
     */
    private RepositoryContract $repository;

    /**
     * ResetPasswordController Constructor.
     *
     * @param  RepositoryContract $repository 認証に関連した処理を行うリポジトリクラス
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(RepositoryContract $repository)
    {
        parent::__construct();

        $this->middleware('guest:' . config('auth.defaults.guard'))->except([
            'ajaxSendResetLinkEmail'
        ]);
        $this->repository = $repository;
    }

    /**
     * パスワード再発行画面を表示する。
     *
     * @return \Illuminate\Contracts\View\View Viewオブジェクト
     */
    public function showLinkRequestForm(): View
    {
        return view(Route::currentRouteName());
    }

    /**
     * パスワード再発行用のメールを送信する。
     *
     * @param  \GLC\Master\Auth\Forms\PasswordResetMailRequest $request PasswordResetMailRequestオブジェクト
     * @return \Illuminate\Http\RedirectResponse RedirectResponseオブジェクト
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function sendResetLinkEmail(PasswordResetMailRequest $request): RedirectResponse
    {
        $response = $this->broker()->sendResetLink(
            $request->only([ 'email' ])
        );

        return $response === Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request->input('email'), $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * メール送信成功時のレスポンスを返す。
     *
     * @param  string $email 送信したメールアドレス
     * @param  string $response レスポンスコード
     * @return \Illuminate\Http\RedirectResponse RedirectResponseオブジェクト
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function sendResetLinkResponse(string $email, string $response): RedirectResponse
    {
        return redirect(route(config('auth.routes.name.guest')))->with('status', trans($response));
    }

    /**
     * メール送信失敗時のレスポンスを返す。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  string $response レスポンスコード
     * @return \Illuminate\Http\RedirectResponse RedirectResponseオブジェクト
     */
    protected function sendResetLinkFailedResponse(Request $request, string $response): RedirectResponse
    {
        return back()
            ->withInput($request->only([ 'email' ]))
            ->withErrors([ 'status' => trans($response) ]);
    }

    /**
     * パスワード変更画面を表示する。
     *
     * @param  string $token パスワード再発行用トークン
     * @return \Illuminate\Contracts\View\View Viewオブジェクト
     */
    public function showResetForm(string $token): View
    {
        return view(Route::currentRouteName(), [
            'token' => $token
        ]);
    }

    /**
     * パスワードを更新する。
     *
     * @param  \GLC\Master\Auth\Forms\PasswordResetRequest $request PasswordResetRequestオブジェクト
     * @return \Illuminate\Http\RedirectResponse RedirectResponseオブジェクト
     */
    public function reset(PasswordResetRequest $request): RedirectResponse
    {
        $response = $this->broker()->reset(
            $request->only([ 'email', 'password', 'password_confirmation', 'token' ]),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response === Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * パスワード更新成功時のレスポンスを返す。
     *
     * @param  string $response レスポンスコード
     * @return \Illuminate\Http\RedirectResponse RedirectResponseオブジェクト
     */
    protected function sendResetResponse(string $response): RedirectResponse
    {
        if (Auth::user()->role === UserDefs::ROLE_CODE_AGENT) {
            return redirect(route(config('auth.routes.name.authenticated_role_agent')))->with('status', trans($response));
        }

        return redirect(route(config('auth.routes.name.authenticated')))->with('status', trans($response));
    }

    /**
     * パスワード更新失敗時のレスポンスを返す。
     *
     * @param  \Illuminate\Http\Request $request Requestオブジェクト
     * @param  string $response レスポンスコード
     * @return \Illuminate\Http\RedirectResponse RedirectResponseオブジェクト
     */
    protected function sendResetFailedResponse(Request $request, string $response): RedirectResponse
    {
        return back()
            ->withInput($request->only([ 'email' ]))
            ->withErrors([ 'status' => trans($response) ]);
    }

    /**
     * パスワードを更新する。
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user 認証モデルクラス
     * @param  string $password 更新するパスワード
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function resetPassword(Authenticatable $user, string $password)
    {
        try {
            $this->repository->updatePassword($user, $password);
        } catch (Throwable $thw) {
            Log::channel('error')->error($thw->getMessage());
        }

        $this->guard()->login($user);
    }

    /**
     * PasswordBrokerを取得する。
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker PasswordBrokerオブジェクト
     */
    protected function broker(): PasswordBroker
    {
        return Password::broker(config('auth.defaults.guard'));
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
     * パスワード再発行用のメールを送信する。
     *
     * @param \GLC\Master\Auth\Forms\PasswordResetMailRequest $request PasswordResetMailRequestオブジェクト
     * @return \Illuminate\Http\JsonResponse RedirectResponseオブジェクト
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function ajaxSendResetLinkEmail(PasswordResetMailRequest $request): \Illuminate\Http\JsonResponse
    {
        $response = $this->broker()->sendResetLink(
            $request->only([ 'email' ])
        );

        if($response === Password::RESET_LINK_SENT) {
            $request->session()->flash('status', '再発行メールを送信しました。');
            return response()->json([ 'OK' ],);
        } else {
            $request->session()->flash('status', '再発行メールの送信に失敗しました。');
            return response()->json([ 'ERROR' ], 500);
        }
    }
}