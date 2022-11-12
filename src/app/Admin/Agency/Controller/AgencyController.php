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
        $this->renderer->setPageTitle('Agency List');

        $this->renderer->setPaginator($this->agencyService->getViewModelPaginator(url()->current(), $request->all()));
        $this->renderer->setSearchConditions($request->all());
        $names = explode('.', Route::current()->getName());

        return view('agency.' . Arr::last($names));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(Request $request): View
    {
        $this->renderer->setPageTitle('Agency Create');

        if (!empty($request->all())) {
            $this->renderer->set('agency', $request->all());
        }
        $names = explode('.', Route::current()->getName());

        return view('agency.' . Arr::last($names));
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
        $this->renderer->setPageTitle('Agency ' . $id);

        if (empty($agency = $this->agencyService->getViewModel(['id' => $id]))) {
            abort(404);
        }
        $this->renderer->set('agency', $agency);
        $names = explode('.', Route::current()->getName());

        return view('agency.' . Arr::last($names), ['agency' => $agency]);
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
        $this->renderer->setPageTitle('Agency Edit');

        if (empty($agency = $this->agencyService->getViewModel(['id' => $id]))) {
            abort(404);
        }

        if (!empty($request->all())) {
            $agency = $this->agencyService->convertArrayToViewModel($request->all());
            $agency->id = $id;
        }
        $this->renderer->set('agency', $agency);
        $names = explode('.', Route::current()->getName());

        return view('agency.' . Arr::last($names));
    }

    /**
     * createConfirm
     *
     * @param AgencyStoreRequest $request
     * @return View
     * @throws \Throwable
     */
    public function createConfirm(AgencyStoreRequest $request): View
    {
        $this->renderer->setPageTitle('Agency Create Confirm');

        $this->renderer->set('request', $request);
        $names = explode('.', Route::current()->getName());

        return view('agency.' . Arr::last($names));
    }

    /**
     * updateConfirm
     *
     * @param AgencyUpdateRequest $request
     * @return View
     * @throws \Throwable
     */
    public function updateConfirm(AgencyUpdateRequest $request): View
    {
        $this->renderer->setPageTitle('Agency Update Confirm');

        $this->renderer->set('request', $request);
        $names = explode('.', Route::current()->getName());

        return view('agency.' . Arr::last($names));
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
