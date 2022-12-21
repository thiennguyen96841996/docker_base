<?php

namespace App\Admin\Agency\Controller;

use App\Admin\Agency\Request\AgencyStoreRequest;
use App\Admin\Agency\Request\AgencyUpdateRequest;
use App\Common\Agency\Service\AgencyService;
use App\Common\AgencyContract\Service\AgencyContractService;
use App\Common\Definition\StatusMessage;
use App\Common\View\Facades\Renderer;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
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
     * @var AgencyContractService
     */
    private AgencyContractService $agencyContractService;

    /**
     * constructor.
     */
    public function __construct(AgencyService $agencyService, AgencyContractService $agencyContractService)
    {
        $this->agencyService = $agencyService;
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
        Renderer::setPageTitle('Danh sách đại lý');

        Renderer::setPaginator($this->agencyService->getViewModelPaginator(
            url()->current(),
            $request->all(),
            ['status' => 'asc', 'establishment_date' => 'desc']
        ));
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
        Renderer::setPageTitle('Tạo mới đại lý');

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
        return redirect()->route('admin.agency.show', ['agency' => $agency->id])->with('status', StatusMessage::SAVED_SUCCESS);
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
        Renderer::setPageTitle('Đại lý ' . $id);

        if (empty($agency = $this->agencyService->getViewModel(['id' => $id]))) {
            abort(404);
        }
        Renderer::set('agency', $agency);
        // Get agency contract now information
        Renderer::set('getContractNow', $this->agencyContractService->getContractNow(['agency_id' => $id]));
        // Get agency contract history information
        Renderer::setPaginator($this->agencyContractService->getViewModelPaginator(url()->current(), ['agency_id' => $id, 'end_date_to' => Carbon::now()]));

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
        Renderer::setPageTitle('Sửa thông tin đại lý');

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
        Renderer::setPageTitle('Xác nhận tạo mới');

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
        Renderer::setPageTitle('Xác nhận cập nhật');

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

        return redirect()->route('admin.agency.show', ['agency' => $id])->with('status', StatusMessage::UPDATED_SUCCESS);
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

        return redirect()->route('admin.agency.index')->with('status', StatusMessage::DELETED_SUCCESS);
    }

    /**
     * csvDownload
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function csvDownload(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $fileName = 'agency-list' . Carbon::parse(now())->timestamp . '.csv';
        $csv = csv_download($fileName);

        Log::debug('before:' . round(memory_get_usage(true)/1048576,2)." megabytes");
        $csvViewModel = $this->agencyService->getCsvViewModelList(
            $request->all(),
            ['status' => 'asc', 'establishment_date' => 'desc']
        );

        $csv->setCsvViewModel($csvViewModel);

        return $csv->csvdownload();
    }
}
