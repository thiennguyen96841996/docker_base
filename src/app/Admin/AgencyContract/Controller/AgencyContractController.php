<?php

namespace App\Admin\AgencyContract\Controller;

use App\Common\AgencyContract\Service\AgencyContractService;
use App\Common\Definition\StatusMessage;
use App\Common\View\Facades\Renderer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Common\Http\Controller\AbsController;
use Illuminate\Http\Request;

/**
 * AgencyContract page。
 * @package \App\Admin\AgencyContract
 */
class AgencyContractController extends AbsController
{
    /**
     * @var AgencyContractService
     */
    private AgencyContractService $agencyContractService;

    /**
     * constructor.
     */
    public function __construct(AgencyContractService $agencyContractService)
    {
        $this->agencyContractService = $agencyContractService;
    }

    /**
     * index
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        Renderer::setPageTitle('Agency Contract List');

        Renderer::setPaginator($this->agencyContractService->getViewModelPaginator(url()->current(), $request->all()));
        Renderer::setSearchConditions($request->all());

        return view('agency-contract.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(Request $request): View
    {
        Renderer::setPageTitle('Agency Contract Create');

        if (!empty($request->all())) {
            Renderer::set('agencyContract', $request->all());
        }

        return view('agency-contract.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * store
     *
     * @param AgencyContractStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(AgencyContractStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $agencyContract = $this->agencyContractService->storeModel($request->all());
        return redirect()->route('admin.agency-contract.show', ['agency-contract' => $agencyContract->id])->with('status', StatusMessage::STORE_SUCCESS);
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
        Renderer::setPageTitle('Agency Contract ' . $id);

        if (empty($agencyContract = $this->agencyContractService->getViewModel(['id' => $id]))) {
            abort(404);
        }
        Renderer::set('agencyContract', $agencyContract);

        return view('agency-contract.' . Arr::last(explode('.', Route::current()->getName())));
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
        Renderer::setPageTitle('Agency Contract Edit');

        if (empty($agencyContract = $this->agencyContractService->getViewModel(['id' => $id]))) {
            abort(404);
        }

        if (!empty($request->all())) {
            $agencyContract = $this->agencyContractService->convertArrayToViewModel($request->all());
            $agencyContract->id = $id;
        }
        Renderer::set('agencyContract', $agencyContract);

        return view('agency-contract.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * createConfirm
     *
     * @param AgencyContractStoreRequest $request
     * @return View
     * @throws \Throwable
     */
    public function createConfirm(AgencyContractStoreRequest $request)
    {
        Renderer::setPageTitle('Agency Contract Create Confirm');

        Renderer::set('request', $request);

        return view('agency-contract.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * updateConfirm
     *
     * @param AgencyContractUpdateRequest $request
     * @return View
     * @throws \Throwable
     */
    public function updateConfirm(AgencyContractUpdateRequest $request)
    {
        Renderer::setPageTitle('Agency Contract Update Confirm');

        Renderer::set('request', $request);

        return view('agency-contract.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * update
     *
     * @param AgencyContractUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(AgencyContractUpdateRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        if (empty($agencyContract = $this->agencyContractService->getModel(['id' => $id]))) {
            abort(404);
        }
        $this->agencyContractService->updateModel($agencyContract, $request->all());

        return redirect()->route('admin.agency-contract.show', ['agency' => $id])->with('status', StatusMessage::UPDATE_SUCCESS);
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
        if (empty($agencyContract = $this->agencyContractService->getModel(['id' => $id]))) {
            abort(404);
        }
        $this->agencyContractService->deleteModel($agencyContract);

        return redirect()->route('admin.agency-contract.index')->with('status', StatusMessage::DELETE_SUCCESS);
    }
}
