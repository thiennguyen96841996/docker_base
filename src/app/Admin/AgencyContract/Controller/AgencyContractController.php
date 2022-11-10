<?php

namespace App\Admin\AgencyContract\Controller;

use App\Admin\AgencyContract\Request\AgencyContractCancel;
use App\Admin\AgencyContract\Request\AgencyContractStoreRequest;
use App\Common\Agency\Service\AgencyService;
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
     * @var AgencyService
     */
    private AgencyService $agencyService;

    /**
     * constructor.
     */
    public function __construct(AgencyContractService $agencyContractService, AgencyService $agencyService,)
    {
        $this->agencyService = $agencyService;
        $this->agencyContractService = $agencyContractService;
    }

    /**
     * create
     *
     * @return View
     */
    public function create(Request $request): View
    {
        Renderer::setPageTitle('Tạo mới hợp đồng đại lý');

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
        return redirect()->route('admin.agency.show', ['agency' => $this->agencyContractService->storeModel($request->all())->agency_id])->with('status', StatusMessage::SAVED_SUCCESS);
    }

    /**
     * show
     *
     * @param string $agencyId
     * @param int $id
     * @return View
     * @throws \Throwable
     */
    public function show(string $agencyId, int $id): View
    {
        Renderer::setPageTitle('Hợp đồng đại lý ' . $id);

        if (empty($agencyContract = $this->agencyContractService->getViewModel(['id' => $id, 'agency_id' => $agencyId]))) {
            abort(404);
        }
        Renderer::set('agency', $this->agencyService->getViewModel(['id' => $agencyId]));
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
    public function createConfirm(AgencyContractStoreRequest $request): view
    {
        Renderer::setPageTitle('Agency Contract Create Confirm');

        Renderer::set('request', $request);

        return view('agency-contract.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * destroy
     *
     * @param int $id
     * @param string $agency_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(string $agency_id, int $id): \Illuminate\Http\RedirectResponse
    {
        if (empty($agencyContract = $this->agencyContractService->getModel(['id' => $id]))) {
            abort(404);
        }
        $this->agencyContractService->deleteModel($agencyContract);

        return redirect()->route('admin.agency.show', ['agency' => $agency_id])->with('status', StatusMessage::DELETED_SUCCESS);
    }

    /**
     * cancel
     *
     * @param AgencyContractCancel $request
     * @param string $agency_id
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function cancel(AgencyContractCancel $request, string $agency_id, int $id): \Illuminate\Http\RedirectResponse
    {
        if (empty($agencyContract = $this->agencyContractService->getModel(['id' => $id]))) {
            abort(404);
        }
        if (empty($agency = $this->agencyService->getModel(['id' => $agency_id]))) {
            abort(404);
        }
        $this->agencyContractService->updateModel($agencyContract, $request->all());
        $this->agencyService->updateModel($agency, $request->all());

        return redirect()->route('admin.agency.show', ['agency' => $agency_id])->with('status', StatusMessage::UPDATED_SUCCESS);
    }
}
