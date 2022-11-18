<?php

namespace App\Admin\CustomerUser\Controller;

use App\Admin\CustomerUser\Request\CustomerUserUpdateRequest;
use App\Common\Customer\Service\CustomerService;
use App\Common\Definition\StatusMessage;
use App\Common\Http\Controller\AbsController;
use App\Common\View\Facades\Renderer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

/**
 * Customer page in admin site。
 * @package \App\Admin\CustomerUser
 */
class CustomerUserController extends AbsController
{
    /**
     * @var CustomerService
     */
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of the customer in admin site.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        Renderer::setPageTitle('Customer List');

        Renderer::setPaginator($this->customerService->getViewModelPaginator(url()->current(),$request->all()));
        Renderer::setSearchConditions($request->all());

        return view('customer-user.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Display the specified customer in admin site.
     *
     * @param  string $id
     * @return \Illuminate\View\View
     */
    public function show(string $id): View
    {
        Renderer::setPageTitle('Customer ' . $id);

        $customer = $this->customerService->getViewModel(['id' => $id]);
        if (is_null($customer)) {
            return view('error.404');
        }
        Renderer::set('customerUser', $customer);

        return view('customer-user.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Edit customer's information
     *
     * @param Request $request
     * @param string $id
     * @return View
     */
    public function edit(Request $request, string $id): View
    {
        Renderer::setPageTitle('Customer Edit');

        $isBack = false;
        $customerUser = $this->customerService->getViewModel(['id' => $id]);
        if (is_null($customerUser)) {
            return view('error.404');
        }

        if (!empty($request->all())) {
            $customerUser = $this->customerService->convertoToViewModel($request->all());
            $customerUser->id = $id;
            $isBack = true;
        }
        Renderer::set('isBack', $isBack);
        Renderer::set('customerUser', $customerUser);

        return view('customer-user.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Confirmation of editing customer's information
     *
     * @param CustomerUserUpdateRequest $request
     * @param string $id
     * @return View
     */
    public function editConfirm(CustomerUserUpdateRequest $request, string $id): View
    {
        Renderer::setPageTitle('Customer Edit Comfirm');

        return view('customer-user.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Update the specified customer in admin site in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $customer = $this->customerService->getModel(['id' => $id]);
        if (is_null($customer)) {
            return view('error.404');
        }
        $this->customerService->updateModel($customer, $request->all());

        return redirect()->route('admin.customer-user.show', ['customer_user' => $id])
            ->with('status', StatusMessage::UPDATE_SUCCESS);
    }

    /**
     * Remove the specified customer in admin site from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(string $id): RedirectResponse
    {
        $customer = $this->customerService->getModel(['id' => $id]);
        if (is_null($customer)) {
            return view('error.404');
        }
        $this->customerService->deleteModel($customer);

        return redirect()->route('admin.customer-user.index')
            ->with('status', StatusMessage::DELETE_SUCCESS);
    }
}
