<?php
namespace App\Admin\Agency\Controller;

use App\Common\Agency\Service\AgencyService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Common\Http\Controller\AbsController;
use Illuminate\Http\Request;

/**
 * ホーム画面に関連する処理を行うクラス。
 * @package \App\Admin\Home
 */
class AgencyController extends AbsController
{
    private $agencyService;

    /**
     * constructor.
     */
    public function __construct(AgencyService $agencyService)
    {
        $this->agencyService = $agencyService;
    }

    /**
     * Agency一覧画面を表示する。
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $agencyList = $this->agencyService->getViewModelPaginator(url()->current(),10, $request->all());
        $names = explode('.', Route::current()->getName());
        return view('agency.'.Arr::last($names), ['agencyList' => $agencyList]);
    }

    /**
     * Agency登録画面を表示する。
     * @return View
     */
    public function create(): View
    {
        $names = explode('.', Route::current()->getName());
        return view('agency.'.Arr::last($names));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $this->agencyService->storeModel($request->all());
        return redirect()->route('admin.agency.index');
    }

    /**
     * Agency詳細画面を表示する。
     * @param $id
     * @return View
     * @throws \Throwable
     */
    public function show($id): View
    {
        $agency = $this->agencyService->getViewModel(['id' => $id]);
        $names = explode('.', Route::current()->getName());
        return view('agency.'.Arr::last($names), ['agency' => $agency]);
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        $agency = $this->agencyService->getOneCollection(['id' => $id]);
        $names = explode('.', Route::current()->getName());
        return view('agency.'.Arr::last($names), ['agency' => $agency]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {
        $agency = $this->agencyService->getOneCollection(['id' => $id]);
        $this->agencyService->updateModel($agency, $request->all());
        return redirect()->route('admin.agency.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy($id)
    {
        $agency = $this->agencyService->getOneCollection(['id' => $id]);
        $this->agencyService->deleteModel($agency);
        return redirect()->route('admin.agency.index');
    }
}
