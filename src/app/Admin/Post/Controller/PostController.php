<?php

namespace App\Admin\Post\Controller;

use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Common\View\Facades\Renderer;
use Illuminate\Support\Facades\Route;
use App\Common\Post\Service\PostService;
// use App\Admin\Post\Request\PostUpdateRequest;
// use App\Common\Definition\StatusMessage;
use App\Common\Http\Controller\AbsController;

/**
 * Post page in admin site。
 * @package \App\Admin\Post
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
     * List post's information
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        Renderer::setPageTitle('Danh sách bài đăng');

        Renderer::setPaginator($this->postService->getViewModelPaginator(url()->current(), $request->all()));
        Renderer::setSearchConditions($request->all());

        return view('post.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Display post's detail
     *
     * @param string $id
     * @return View
     * @throws \Throwable
     */
    public function show(string $id): View
    {
        Renderer::setPageTitle('Bài đăng ' . $id);

        if (empty($post = $this->postService->getViewModel(['id' => $id]))) {
            abort(404);
        }
        Renderer::set('post', $post);

        return view('post.' . Arr::last(explode('.', Route::current()->getName())));
    }

    // /**
    //  * Update post's information
    //  *
    //  * @param Request $request
    //  * @param string $id
    //  * @return View
    //  */
    // public function edit(Request $request, string $id): View
    // {
    //     Renderer::setPageTitle('Post Edit'');

    //     $isBack = false;
    //     if (empty($post = $this->postService->getViewModel(['id' => $id]))) {
    //         abort(404);
    //     }

    //     if (!empty($request->all())) {
    //         $post = $this->postService->convertArrayToViewModel($request->all());
    //         $post->id = $id;
    //         $isBack = true;
    //     }

    //     Renderer::set('isBack', $isBack);
    //     Renderer::set('post', $post);

    //     return view('post.' . Arr::last(explode('.', Route::current()->getName())));
    // }

    // /**
    //  * Confirmation of editing post's information
    //  *
    //  * @param PostUpdateRequest $request
    //  * @param string $id
    //  * @return View
    //  */
    // public function updateConfirm(PostUpdateRequest $request, string $id): View
    // {
    //     Renderer::setPageTitle('Post Update Confirm');

    //     if (!empty($post = $this->postService->getViewModel(['id' => $request->input('id')]))) {
    //         Renderer::set('post', $post);
    //     }

    //     return view('post.' . Arr::last(explode('.', Route::current()->getName())));
    // }

    // /**
    //  * Update DB
    //  *
    //  * @param Request $request
    //  * @param string $id
    //  * @return \Illuminate\Http\RedirectResponse
    //  * @throws \Throwable
    //  */
    // public function update(PostUpdateRequest $request, string $id): \Illuminate\Http\RedirectResponse
    // {
    //     if (empty($post = $this->postService->getModel(['id' => $id]))) {
    //         abort(404);
    //     }
    //     $this->postService->updateModel($post, $request->all());

    //     return redirect()->route('admin.post.show', ['post' => $id])->with('status', StatusMessage::UPDATE_SUCCESS);
    // }

    // /**
    //  * Delete post
    //  *
    //  * @param $id
    //  * @return \Illuminate\Http\RedirectResponse
    //  * @throws \Throwable
    //  */
    // public function destroy(string $id): \Illuminate\Http\RedirectResponse
    // {
    //     if (empty($post = $this->postService->getModel(['id' => $id]))) {
    //         abort(404);
    //     }
    //     $this->postService->deleteModel($post);

    //     return redirect()->route('admin.post.index')->with('status', StatusMessage::DELETE_SUCCESS);
    // }
}
