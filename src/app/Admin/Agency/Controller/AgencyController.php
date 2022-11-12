<?php

namespace App\Admin\Agency\Controller;

use App\Admin\Agency\Request\AgencyStoreRequest;
use App\Admin\Agency\Request\AgencyUpdateRequest;
use App\Common\Agency\Service\AgencyService;
use App\Common\Definition\StatusMessage;
use App\Common\View\Facades\Renderer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Common\Http\Controller\AbsController;
use Illuminate\Http\Request;

/**
 * agency page。
 * @package \App\Admin\Agency
 */
class AgencyController extends AbsController
{
    /**
     * @var AgencyService
     */
    private AgencyService $agencyService;

    /**
     * constructor.
     */
    public function __construct(AgencyService $agencyService)
    {
        $this->agencyService = $agencyService;
    }

    /**
     * index
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        Renderer::setPageTitle('Agency List');

        Renderer::setPaginator($this->agencyService->getViewModelPaginator(url()->current(), $request->all()));
        Renderer::setSearchConditions($request->all());

        return view('agency.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(Request $request): View
    {
        Renderer::setPageTitle('Agency Create');

        if (!empty($request->all())) {
            Renderer::set('agency', $request->all());
        }

        return view('agency.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * store
     *
     * @param AgencyStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(AgencyStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $agency = $this->agencyService->storeModel($request->all());
        return redirect()->route('admin.agency.show', ['agency' => $agency->id])->with('status', StatusMessage::STORE_SUCCESS);
    }

    /**
     * show
     *
     * @param int $id
     * @return View
     * @throws \Throwable
     */
    public function show(int $id): View
    {
        Renderer::setPageTitle('Agency ' . $id);

        if (empty($agency = $this->agencyService->getViewModel(['id' => $id]))) {
            abort(404);
        }
        Renderer::set('agency', $agency);

        return view('agency.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * edit
     *
     * @param Request $request
     * @param int $id
     * @return View
     * @throws \Throwable
     */
    public function edit(Request $request, int $id): View
    {
        Renderer::setPageTitle('Agency Edit');

        if (empty($agency = $this->agencyService->getViewModel(['id' => $id]))) {
            abort(404);
        }

        if (!empty($request->all())) {
            $agency = $this->agencyService->convertArrayToViewModel($request->all());
            $agency->id = $id;
        }
        Renderer::set('agency', $agency);

        return view('agency.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * createConfirm
     *
     * @param AgencyStoreRequest $request
     * @return View
     * @throws \Throwable
     */
    public function createConfirm(AgencyStoreRequest $request)
    {
        Renderer::setPageTitle('Agency Create Confirm');

        Renderer::set('request', $request);

        return view('agency.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * updateConfirm
     *
     * @param AgencyUpdateRequest $request
     * @return View
     * @throws \Throwable
     */
    public function updateConfirm(AgencyUpdateRequest $request)
    {
        Renderer::setPageTitle('Agency Update Confirm');

        Renderer::set('request', $request);

        return view('agency.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * update
     *
     * @param AgencyUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(AgencyUpdateRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        if (empty($agency = $this->agencyService->getModel(['id' => $id]))) {
            abort(404);
        }
        $this->agencyService->updateModel($agency, $request->all());

        return redirect()->route('admin.agency.show', ['agency' => $id])->with('status', StatusMessage::UPDATE_SUCCESS);
    }

    /**
     * destroy
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        if (empty($agency = $this->agencyService->getModel(['id' => $id]))) {
            abort(404);
        }
        $this->agencyService->deleteModel($agency);

        return redirect()->route('admin.agency.index')->with('status', StatusMessage::DELETE_SUCCESS);
    }
}
