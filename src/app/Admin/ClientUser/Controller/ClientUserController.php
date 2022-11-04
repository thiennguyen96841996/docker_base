<?php
namespace App\Admin\ClientUser\Controller;

use App\Admin\ClientUser\Notifications\SendPassword;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Common\View\Facades\Renderer;
use Illuminate\Support\Facades\Route;
use App\Common\ClientUser\Model\ClientUser;
use App\Common\Agency\Service\AgencyService;
use App\Common\Http\Controller\AbsController;
use App\Common\ClientUser\Service\ClientUserService;
use App\Admin\ClientUser\Request\ClientUserStoreRequest;
use App\Admin\ClientUser\Request\ClientUserUpdateRequest;

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
        Renderer::setPaginator($this->clientUserService->getViewModelPaginator(url()->current(),10, $request->all()));
        Renderer::setSearchConditions($request->all());
        $names = explode('.', Route::current()->getName());

        return view('clientUser.'.Arr::last($names));
    }

    /**
     * Create new client
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!empty($request->all())) {
            Renderer::set('clientUser', $request->all());
        }
        $agencies = $this->agencyService->getViewModelCollection();
        Renderer::set('agencies', $agencies);
        $names = explode('.', Route::current()->getName());
        return view('clientUser.'.Arr::last($names));
    }

    /**
     * Confirmation of creating new client
     *
     * @param ClientUserStoreRequest $request
     * @return View
     */
    public function createConfirm(ClientUserStoreRequest $request): View
    {
        if (!empty($agency = $this->agencyService->getViewModel(['id' => $request->input('agency_id')]))) {
            Renderer::set('agency', $agency);
        }
        $names = explode('.', Route::current()->getName());
        return view('clientUser.'.Arr::last($names));
    }

     /**
     *  Saving DB
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $storeData = $request->all();
        $storeData['password'] = makeRandomStrForPassword();
        $clientUser = $this->clientUserService->storeModel($storeData);

        // Password send mail
        $clientViewModel = $this->clientUserService->getViewModel(['id' => $clientUser->id]);
        $clientUser->notify(new SendPassword($clientViewModel, $storeData['password']));

        return redirect()->route('admin.clientUser.show', ['clientUser' => $clientUser->id])->with('status', 'store success');
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
        if (empty($clientUser = $this->clientUserService->getViewModel(['id' => $id]))) {
            abort(404);
        }
        Renderer::set('clientUser', $clientUser);
        $names = explode('.', Route::current()->getName());

        return view('clientUser.'.Arr::last($names));
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
        $isBack = false;
        if (empty($clientUser = $this->clientUserService->getViewModel(['id' => $id]))) {
            abort(404);
        }

        if (!empty($request->all())) {
            $clientUser = $this->clientUserService->convertoToViewModel($request->all());
            $clientUser->id = $id;
            $isBack = true;
        }

        $agencies = $this->agencyService->getViewModelCollection();
        Renderer::set('isBack', $isBack);
        Renderer::set('clientUser', $clientUser);
        Renderer::set('agencies', $agencies);
        $names = explode('.', Route::current()->getName());

        return view('clientUser.'.Arr::last($names));
    }

    /**
     * Confirmation of editing client's information
     *
     * @param ClientUserUpdateRequest $request
     * @param string $id
     * @return View
     */
    public function editConfirm(ClientUserUpdateRequest $request, string $id): View
    {
        if (!empty($agency = $this->agencyService->getViewModel(['id' => $request->input('agency_id')]))) {
            Renderer::set('agency', $agency);
        }
        $names = explode('.', Route::current()->getName());
        return view('clientUser.'.Arr::last($names));
    }

    /**
     * Update DB
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        if (empty($clientUser = $this->clientUserService->getModel(['id' => $id]))) {
            abort(404);
        }
        $this->clientUserService->updateModel($clientUser, $request->all());

        return redirect()->route('admin.clientUser.show', ['clientUser' => $id])->with('status', 'update success');
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

        return redirect()->route('admin.clientUser.index')->with('status', 'delete success');
    }
}
