<?php

namespace App\Admin\ClientUser\Controller;

use App\Admin\ClientUser\Notifications\SendPassword;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Common\View\Facades\Renderer;
use Illuminate\Support\Facades\Route;
use App\Common\Agency\Service\AgencyService;
use App\Common\Http\Controller\AbsController;
use App\Common\ClientUser\Service\ClientUserService;
use App\Admin\ClientUser\Request\ClientUserStoreRequest;
use App\Admin\ClientUser\Request\ClientUserUpdateRequest;
use App\Common\Definition\StatusMessage;

/**
 * Client page in admin site。
 * @package \App\Admin\ClientUser
 */
class ClientUserController extends AbsController
{
    /**
     * @var ClientUserService
     */
    private ClientUserService $clientUserService;

    /**
     * @var AgencyService
     */
    private AgencyService $agencyService;

    /**
     * constructor.
     */
    public function __construct(ClientUserService $clientUserService, AgencyService $agencyService)
    {
        $this->clientUserService = $clientUserService;
        $this->agencyService = $agencyService;
    }

    /**
     * List client's information
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        Renderer::setPageTitle('Client List');

        Renderer::setPaginator($this->clientUserService->getViewModelPaginator(url()->current(), $request->all()));
        Renderer::setSearchConditions($request->all());

        return view('client-user.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Create new client
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        Renderer::setPageTitle('Client Create');

        if (!empty($request->all())) {
            Renderer::set('clientUser', $request->all());
        }
        Renderer::set('agency', $this->agencyService->getViewModel(['id' => $request->query('agency_id')]));

        return view('client-user.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Confirmation of creating new client
     *
     * @param ClientUserStoreRequest $request
     * @return View
     */
    public function createConfirm(ClientUserStoreRequest $request): View
    {
        Renderer::setPageTitle('Client Create Confirm');

        if (!empty($agency = $this->agencyService->getViewModel(['id' => $request->input('agency_id')]))) {
            Renderer::set('agency', $agency);
        }

        return view('client-user.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     *  Saving DB
     *
     * @param ClientUserStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(ClientUserStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $storeData = $request->all();
        $storeData['password'] = makeRandomStrForPassword();
        $clientUser = $this->clientUserService->storeModel($storeData);

        // Password send mail
        $clientViewModel = $this->clientUserService->getViewModel(['id' => $clientUser->id]);
        $clientUser->notify(new SendPassword($clientViewModel, $storeData['password']));

        return redirect()->route('admin.client-user.show', $clientUser->id)->with('status', StatusMessage::STORE_SUCCESS);
    }

    /**
     * Display client's detail
     *
     * @param string $id
     * @return View
     * @throws \Throwable
     */
    public function show(string $id): View
    {
        Renderer::setPageTitle('Client ' . $id);

        if (empty($clientUser = $this->clientUserService->getViewModel(['id' => $id]))) {
            abort(404);
        }
        Renderer::set('clientUser', $clientUser);

        return view('client-user.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Update client's information
     *
     * @param Request $request
     * @param string $id
     * @return View
     */
    public function edit(Request $request, string $id): View
    {
        Renderer::setPageTitle('Client Edit');

        $isBack = false;
        if (empty($clientUser = $this->clientUserService->getViewModel(['id' => $id]))) {
            abort(404);
        }

        if (!empty($request->all())) {
            $clientUser = $this->clientUserService->convertoToViewModel($request->all());
            $clientUser->id = $id;
            $isBack = true;
        }

        Renderer::set('isBack', $isBack);
        Renderer::set('clientUser', $clientUser);

        return view('client-user.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Confirmation of editing client's information
     *
     * @param ClientUserUpdateRequest $request
     * @param string $id
     * @return View
     */
    public function updateConfirm(ClientUserUpdateRequest $request, string $id): View
    {
        Renderer::setPageTitle('Client Update Confirm');

        if (!empty($agency = $this->agencyService->getViewModel(['id' => $request->input('agency_id')]))) {
            Renderer::set('agency', $agency);
        }

        return view('client-user.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Update DB
     *
     * @param ClientUserUpdateRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(ClientUserUpdateRequest $request, string $id): \Illuminate\Http\RedirectResponse
    {
        if (empty($clientUser = $this->clientUserService->getModel(['id' => $id]))) {
            abort(404);
        }
        $this->clientUserService->updateModel($clientUser, $request->all());

        return redirect()->route('admin.client-user.show', $id)->with('status', StatusMessage::UPDATE_SUCCESS);
    }

    /**
     * Delete client
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        if (empty($clientUser = $this->clientUserService->getModel(['id' => $id]))) {
            abort(404);
        }
        $this->clientUserService->deleteModel($clientUser);

        return redirect()->route('admin.client-user.index')->with('status', StatusMessage::DELETE_SUCCESS);
    }
}
