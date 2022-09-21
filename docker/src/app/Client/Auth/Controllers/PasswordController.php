<?php
namespace GLC\Client\Auth\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Throwable;
use GLC\Client\Http\Controllers\AbsBaseController as BaseController;
use GLC\Platform\Auth\Contracts\AuthRepository as AuthRepositoryContract;
use GLC\Client\Auth\Forms\PasswordUpdateRequest;

/**
 * パスワードに関連した処理を行うコントローラークラス。
 *
 * @package GLC\Client\Auth\Controllers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class PasswordController extends BaseController
{
    /**
     * 認証に関連した処理を行うリポジトリクラス。
     * @var AuthRepositoryContract
     */
    protected AuthRepositoryContract $authRepository;

    /**
     * PasswordController Constructor.
     *
     * @param  AuthRepositoryContract $authRepository 認証に関連した処理を行うリポジトリクラス
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(AuthRepositoryContract $authRepository)
    {
        parent::__construct();

        $this->authRepository = $authRepository;
    }

    /**
     * パスワード変更画面を表示する。
     *
     * @return \Illuminate\Contracts\View\View Viewオブジェクト
     */
    public function index(): View
    {
        $this->renderer->setPageTitle('パスワード変更');

        return view(Route::currentRouteName());
    }

    /**
     * パスワードを変更する。
     *
     * @param  \GLC\Client\Auth\Forms\PasswordUpdateRequest $request PasswordUpdateRequestオブジェクト
     * @return \Illuminate\Http\RedirectResponse RedirectResponseオブジェクト
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update(PasswordUpdateRequest $request): RedirectResponse
    {
        /** @var \GLC\Platform\Auth\Models\AuthEmployee $user */
        $user = Auth::guard(config('auth.client.guard'))->user();

        //TODO:リファクタリング
        unset($user->ids);
        unset($user->active_id);
        unset($user->shop_name);
        unset($user->group_id);
        unset($user->role);
        unset($user->employee_account_id);

        $firstLogin = false;
        if (is_null($user->last_password_updated_at)) {
            $firstLogin = true;
        }

        try {
            $this->authRepository->updatePassword(Auth::user(), $request->input('password'));
        } catch (Throwable $thw) {
            Log::channel('error')->error($thw->getMessage());
        }

        return redirect(route(config('auth.routes.name.authenticated')))
            ->with([ 'status' => 'パスワードを更新しました。' ]);
    }
}