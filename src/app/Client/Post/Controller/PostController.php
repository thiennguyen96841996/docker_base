<?php
namespace App\Client\Post\Controller;

use App\Client\Post\Request\PostStoreRequest;
use App\Client\Post\Request\PostUpdateRequest;
use App\Common\Post\Service\PostService;
use App\Common\View\Facades\Renderer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Common\Http\Controller\AbsController;
use Illuminate\Http\Request;
use Storage;

/**
 * Post page。
 * @package \App\Client\Post
 */
class PostController extends AbsController
{
    /**
     * @var PostService
     */
    private PostService $postService;

    /**
     * constructor.
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * index
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        Renderer::setPaginator($this->postService->getViewModelPaginator(url()->current(),10, $request->all()));
        Renderer::setSearchConditions($request->all());
        $names = explode('.', Route::current()->getName());

        return view('post.'.Arr::last($names));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(Request $request): View
    {
        if (!empty($request->all())) {
            Renderer::set('post', $request->all());
        }

        $names = explode('.', Route::current()->getName());
        return view('post.'.Arr::last($names));
    }

    /**
     * store
     *
     * @param PostStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(PostStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $post = $this->postService->storeModel($request->all());
        return redirect()->route('client.post.show', ['post' => $post->id])->with('status', 'store success');
    }

    /**
     * show
     *
     * @param string $id
     * @return View
     * @throws \Throwable
     */
    public function show(string $id): View
    {
        if (empty($post = $this->postService->getViewModel(['id' => $id]))) {
            abort(404);
        }
        Renderer::set('post', $post);
        $names = explode('.', Route::current()->getName());

        return view('post.'.Arr::last($names), ['post' => $post]);
    }

    /**
     * edit
     *
     * @param Request $request
     * @param string $id
     * @return View
     * @throws \Throwable
     */
    public function edit(Request $request, string $id): View
    {
        if (empty($post = $this->postService->getViewModel(['id' => $id]))) {
            abort(404);
        }
        if (!empty($request->all())) {
            $post = $this->postService->convertArrayToViewModel($request->all());
            $post->id = $id;
        }
        Renderer::set('post', $post);
        $names = explode('.', Route::current()->getName());

        return view('post.'.Arr::last($names));
    }

    /**
     * createConfirm
     *
     * @param PostStoreRequest $request
     * @return View
     * @throws \Throwable
     */
    public function createConfirm(PostStoreRequest $request)
    {
        Renderer::set('request', $request);
        $names = explode('.', Route::current()->getName());

        return view('post.'.Arr::last($names));
    }

    /**
     * updateConfirm
     *
     * @param PostUpdateRequest $request
     * @return View
     * @throws \Throwable
     */
    public function updateConfirm(PostUpdateRequest $request)
    {

        Renderer::set('request', $request);
        $names = explode('.', Route::current()->getName());

        return view('post.'.Arr::last($names));
    }

    /**
     * update
     *
     * @param PostUpdateRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(PostUpdateRequest $request, string $id): \Illuminate\Http\RedirectResponse
    {
        if (empty($post = $this->postService->getModel(['id' => $id]))) {
            abort(404);
        }
        $this->postService->updateModel($post, $request->all());

        return redirect()->route('client.post.show', ['post' => $id])->with('status', 'update success');
    }

    /**
     * destroy
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        if (empty($post = $this->postService->getModel(['id' => $id]))) {
            abort(404);
        }
        $this->postService->deleteModel($post);

        return redirect()->route('client.post.index')->with('status', 'delete success');
    }
}
