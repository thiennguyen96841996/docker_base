<?php
namespace GLC\Master\Auth\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use GLC\Platform\User\Definitions\UserDefs;
use Throwable;
use GLC\Master\Http\Controllers\AbsBaseController as BaseController;
use GLC\Platform\Auth\Contracts\AuthRepository as RepositoryContract;
use GLC\Master\Auth\Forms\PasswordUpdateRequest;

/**
 * パスワードに関連した処理を行うコントローラークラス。
 *
 * @package GLC\Master\Auth\Controllers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class PasswordController extends BaseController
{
    /**
     * 認証に関連した処理を行うリポジトリクラス。
     * @var RepositoryContract
     */
    protected RepositoryContract $repository;

    /**
     * PasswordController Constructor.
     *
     * @param  RepositoryContract $repository 認証に関連した処理を行うリポジトリクラス
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(RepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;
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
     * @param  \GLC\Master\Auth\Forms\PasswordUpdateRequest $request PasswordUpdateRequestオブジェクト
     * @return \Illuminate\Http\RedirectResponse RedirectResponseオブジェクト
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update(PasswordUpdateRequest $request): RedirectResponse
    {
        try {
            $this->repository->updatePassword(Auth::user(), $request->input('password'));
        } catch (Throwable $thw) {
            Log::channel('error')->error($thw->getMessage());
        }

        if (Auth::user()->role === UserDefs::ROLE_CODE_AGENT) {
            return redirect(route(config('auth.routes.name.authenticated_role_agent')))->with([ 'status' => 'パスワードを更新しました。' ]);
        }

        return redirect(route(config('auth.routes.name.authenticated')))->with([ 'status' => 'パスワードを更新しました。' ]);
    }
}