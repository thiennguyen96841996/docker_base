<?php

namespace App\Admin\BookmarkLink\Controller;

use App\Admin\BookmarkLink\Request\BookmarkLinkStoreRequest;
use App\Common\BookmarkLink\Service\BookmarkLinkService;
use App\Common\Definition\StatusMessage;
use App\Common\View\Facades\Renderer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Common\Http\Controller\AbsController;
use Illuminate\Http\Request;

/**
 * BookmarkLink page。
 * @package \App\Admin\BookmarkLink
 */
class BookmarkLinkController extends AbsController
{
    /**
     * @var BookmarkLinkService
     */
    private BookmarkLinkService $bookmarkService;

    /**
     * constructor.
     */
    public function __construct(BookmarkLinkService $bookmarkService)
    {
        $this->bookmarkService = $bookmarkService;
    }

    /**
     * index
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        Renderer::setPageTitle('Danh sách Bookmark');

        Renderer::setPaginator($this->bookmarkService->getViewModelPaginator(url()->current(), $request->all()));
        Renderer::setSearchConditions($request->all());

        return view('bookmark.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * store
     *
     * @param BookmarkLinkStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(BookmarkLinkStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $createdBookmark = $this->bookmarkService->storeModel($request->all());

        // update session
        $items = $request->session()->get('bookmark', []);
        $items[$createdBookmark->id] = Arr::only($createdBookmark->toArray(), ['id', 'name', 'link']);
        $request->session()->put('bookmark', $items);
        // $request->session()->push('bookmark', Arr::only($createdBookmark->toArray(), ['id', 'name', 'link']));

        return redirect()->back()->with('status', StatusMessage::SAVED_SUCCESS);
    }

    /**
     * destroy
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        if (empty($bookmark = $this->bookmarkService->getModel(['id' => $id]))) {
            abort(404);
        }
        $this->bookmarkService->deleteModel($bookmark);

        // delete from session
        $items = $request->session()->get('bookmark', []);
        if (!empty($items[$bookmark->id])) {
            unset($items[$bookmark->id]);
            $request->session()->put('bookmark', $items);
        }

        return redirect()->route('admin.bookmark.index')->with('status', StatusMessage::DELETED_SUCCESS);
    }
}
