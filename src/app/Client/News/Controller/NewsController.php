<?php

namespace App\Client\News\Controller;

use App\Client\News\Request\NewsStoreRequest;
use App\Client\News\Request\NewsUpdateRequest;
use App\Common\Http\Controller\AbsController;
use App\Common\News\Service\NewsService;
use App\Common\View\Facades\Renderer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

/**
 * News page
 * @package \App\Client\News\
 */
class NewsController extends AbsController
{
    /**
     * @var NewsService
     */
    public NewsService $newsService;

    /**
     * constructor
     */
    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * Display a index of the news page.
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        Renderer::setPaginator($this->newsService->getViewModelPaginator(url()->current(), 10, $request->all()));
        Renderer::setSearchConditions($request->all());

        return view('news.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * createConfirm
     *
     * @param NewsStoreRequest $request
     * @return View
     * @throws \Throwable
     */
    public function createConfirm(NewsStoreRequest $request): View
    {
        return view('news.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Show the form for creating a news.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request): View
    {
        if (!empty($request->all())) {
            Renderer::set('news', $request->all());
        }

        return view('news.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Store a newly created news in DB.
     *
     * @param  \App\Client\News\Request\NewsStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NewsStoreRequest $request): RedirectResponse
    {
        $news = $this->newsService->storeModel($request->all());

        return redirect()->route('client.news.show', ['news' => $news->id])->with('status', 'store success');
    }

    /**
     * Display the specified news.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     * @throws \Throwable
     */
    public function show(string $id): View
    {
        $news = $this->newsService->getViewModel(['id' => $id]);
        if (empty($news)) {
            abort(404);
        }

        Renderer::set('news', $news);

        return view('news.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Show the form for editing the specified news.
     *
     * @param Request $request
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, string $id): View
    {
        $news = $this->newsService->getViewModel(['id' => $id]);
        if (empty($news)) {
            abort(404);
        }
        if (!empty($request->all())) {
            $news = $this->newsService->convertArrayToViewModel($request->all());
            $news->id = $id;
        }

        Renderer::set('news', $news);

        return view('news.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * updateConfirm
     *
     * @param NewsUpdateRequest $request
     * @return View
     * @throws \Throwable
     */
    public function updateConfirm(NewsUpdateRequest $request): View
    {
        return view('news.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Update the specified news in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $news = $this->newsService->getModel(['id' => $id]);
        if (empty($news)) {
            abort(404);
        }

        $this->newsService->updateModel($news, $request->all());

        return redirect()->route('client.news.show', ['news' => $news->id])->with('status', 'update success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $news = $this->newsService->getModel(['id' => $id]);
        if (empty($news)) {
            abort(404);
        }

        $this->newsService->deleteModel($news);

        return redirect()->route('client.news.index')->with('status', 'delete success');
    }
}
